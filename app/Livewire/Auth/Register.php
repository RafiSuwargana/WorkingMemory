<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $success_message = '';
    public $error_message = '';
    public $processing = false;

    public function register()
    {
        $this->processing = true;
        $this->success_message = '';
        $this->error_message = '';

        // Validasi sederhana
        if (empty($this->name)) {
            $this->error_message = 'Nama harus diisi!';
            $this->processing = false;
            return;
        }

        if (empty($this->email)) {
            $this->error_message = 'Email harus diisi!';
            $this->processing = false;
            return;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->error_message = 'Format email tidak valid!';
            $this->processing = false;
            return;
        }

        if (empty($this->password)) {
            $this->error_message = 'Password harus diisi!';
            $this->processing = false;
            return;
        }

        if (strlen($this->password) < 8) {
            $this->error_message = 'Password minimal 8 karakter!';
            $this->processing = false;
            return;
        }

        if ($this->password !== $this->password_confirmation) {
            $this->error_message = 'Konfirmasi password tidak cocok!';
            $this->processing = false;
            return;
        }

        try {
            // Cek email sudah ada atau belum
            if (User::where('email', $this->email)->exists()) {
                $this->error_message = 'Email sudah terdaftar!';
                $this->processing = false;
                return;
            }

            // Buat user baru
            DB::beginTransaction();

            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = Hash::make($this->password);
            $user->save();

            // Assign peserta role to new user
            $user->assignRole('peserta');

            DB::commit();

            // Verifikasi user tersimpan
            $savedUser = User::find($user->id);
            if (!$savedUser) {
                throw new \Exception('User tidak tersimpan ke database');
            }

            // Login otomatis
            Auth::login($user);

            $this->success_message = 'REGISTRASI BERHASIL! Mengarahkan ke dashboard...';

            // Tunggu sebentar agar user bisa lihat pesan sukses
            $this->dispatch('registration-success');

            $this->processing = false;

            // Redirect ke dashboard
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error_message = 'Registrasi gagal: ' . $e->getMessage();
            $this->processing = false;
        }
    }

    public function testData()
    {
        $random = rand(1000, 9999);
        $this->name = "Test User {$random}";
        $this->email = "test{$random}@test.com";
        $this->password = "password123";
        $this->password_confirmation = "password123";
        $this->success_message = 'Data test berhasil diisi!';
    }

    public function clearAll()
    {
        $this->reset();
        $this->success_message = 'Form berhasil dibersihkan!';
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
