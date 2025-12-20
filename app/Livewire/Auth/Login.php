<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $message = '';
    public $error = '';

    public function mount()
    {
        $this->reset();
    }

    public function login()
    {
        Log::info('🔐 LOGIN STARTED', ['email' => $this->email]);

        // Clear previous messages
        $this->message = '';
        $this->error = '';

        // Check if device is mobile
        if ($this->isMobileDevice()) {
            $this->error = 'Akses ditolak. Aplikasi ini hanya dapat diakses melalui laptop atau komputer desktop. Silakan gunakan perangkat yang sesuai.';
            Log::warning('❌ LOGIN BLOCKED - MOBILE DEVICE', [
                'email' => $this->email,
                'user_agent' => request()->userAgent()
            ]);
            return;
        }

        // Simple validation
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->error = 'Email valid harus diisi';
            return;
        }

        if (empty($this->password)) {
            $this->error = 'Password harus diisi';
            return;
        }

        try {
            // Attempt login
            if (Auth::attempt([
                'email' => $this->email,
                'password' => $this->password
            ], $this->remember)) {
                
                session()->regenerate();
                
                Log::info('✅ LOGIN SUCCESS', ['user_id' => Auth::id()]);
                
                $this->message = 'LOGIN BERHASIL! Redirecting...';
                
                // Redirect to dashboard
                return redirect()->route('dashboard');
                
            } else {
                Log::warning('❌ LOGIN FAILED', ['email' => $this->email]);
                $this->error = 'Email atau password salah';
            }
            
        } catch (\Exception $e) {
            Log::error('❌ LOGIN ERROR: ' . $e->getMessage());
            $this->error = 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }

    /**
     * Check if current device is mobile
     */
    private function isMobileDevice()
    {
        $userAgent = request()->userAgent();
        
        // List of mobile device keywords
        $mobileKeywords = [
            'Mobile', 'Android', 'iPhone', 'iPad', 'iPod', 
            'BlackBerry', 'Windows Phone', 'webOS', 'Opera Mini',
            'IEMobile', 'Opera Mobi', 'Samsung', 'Nokia', 'Huawei'
        ];
        
        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
    }

    public function testLivewire()
    {
        $this->message = 'Livewire Login bekerja dengan baik!';
        Log::info('✅ LOGIN LIVEWIRE TEST OK');
    }

    public function testData()
    {
        // Isi dengan data test (gunakan data user yang sudah ada di database)
        $this->email = 'test@example.com';
        $this->password = 'password123';
        $this->message = 'Data test berhasil diisi! Email: test@example.com, Password: password123';
    }

    public function clearForm()
    {
        $this->reset();
        $this->message = 'Form berhasil dibersihkan';
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
