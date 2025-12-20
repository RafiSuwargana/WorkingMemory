<?php

namespace App\Exports;

use App\Models\User;
use App\Models\TestSession;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Collection;

class TestResultsExport implements WithMultipleSheets
{
    protected $testType;

    public function __construct($testType = 'all')
    {
        $this->testType = $testType;
    }

    public function sheets(): array
    {
        $sheets = [];

        if ($this->testType === 'all') {
            $sheets[] = new TestTypeSheet('speed');
            $sheets[] = new TestTypeSheet('energy');
            $sheets[] = new TestTypeSheet('capacity');
        } else {
            $sheets[] = new TestTypeSheet($this->testType);
        }

        return $sheets;
    }
}

class TestTypeSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $testType;

    public function __construct($testType)
    {
        $this->testType = $testType;
    }

    public function collection()
    {
        // Get users who have completed this test type
        $sessions = TestSession::where('test_type', $this->testType)
            ->where('status', 'completed')
            ->with([
                'user',
                'testResults' => function ($query) {
                    $query->orderBy('question_number');
                }
            ])
            ->get()
            ->groupBy('user_id');

        $data = collect();
        $no = 1;

        foreach ($sessions as $userId => $userSessions) {
            // Get the latest completed session for this user
            $session = $userSessions->first();

            if (!$session || !$session->user) {
                continue;
            }

            $row = [
                'no' => $no++,
                'nama' => $session->user->name,
            ];

            // Add answers (1 for correct, 0 for incorrect)
            foreach ($session->testResults as $result) {
                $row["Q{$result->question_number}"] = $result->is_correct ? '1' : '0';
            }

            $data->push($row);
        }

        return $data;
    }

    public function headings(): array
    {
        // Get maximum question number for this test type
        $maxQuestions = TestSession::where('test_type', $this->testType)
            ->where('status', 'completed')
            ->with('testResults')
            ->get()
            ->flatMap(function ($session) {
                return $session->testResults;
            })
            ->max('question_number') ?? 20;

        $headings = ['No.', 'Nama'];

        for ($i = 1; $i <= $maxQuestions; $i++) {
            $headings[] = 'Q' . $i;
        }

        return $headings;
    }

    public function title(): string
    {
        return ucfirst($this->testType) . ' Test';
    }
}
