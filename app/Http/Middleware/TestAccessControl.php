<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TestSession;
use App\Livewire\Tests\SpeedTask;

class TestAccessControl
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @param  string  $testType
   * @param  string  $pageType (optional: 'test' or 'instruction')
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next, string $testType, string $pageType = 'test')
  {
    if (!Auth::check()) {
      return redirect()->route('login');
    }

    $userId = Auth::id();
    $nextAllowedTest = SpeedTask::getNextTestType($userId);

    // Check if user is trying to access a test they shouldn't
    if ($nextAllowedTest !== $testType) {
      // If trying to access a test they've already completed
      $completedTest = TestSession::where('user_id', $userId)
        ->where('test_type', $testType)
        ->where('status', 'completed')
        ->exists();

      if ($completedTest && $pageType === 'test') {
        return redirect()->route('dashboard')
          ->with('error', "Tes {$testType} sudah selesai dikerjakan!");
      }

      // If trying to access a future test (haven't completed prerequisites)
      if ($nextAllowedTest) {
        $testNames = [
          'speed' => 'Speed',
          'energy' => 'Energy',
          'capacity' => 'Capacity'
        ];

        $pageTypeText = $pageType === 'instruction' ? 'instruksi' : 'tes';

        return redirect()->route('dashboard')
          ->with('error', "Selesaikan tes {$testNames[$nextAllowedTest]} terlebih dahulu sebelum mengakses {$pageTypeText} {$testNames[$testType]}!");
      } else {
        // All tests completed
        return redirect()->route('dashboard')
          ->with('message', 'Semua tes telah selesai!');
      }
    }

    return $next($request);
  }
}
