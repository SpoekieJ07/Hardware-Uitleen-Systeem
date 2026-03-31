<?php

namespace App\Console\Commands;

use App\Mail\ReturnReminderMail;
use App\Models\Uitleen;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReturnReminders extends Command
{
    protected $signature = 'reminders:send-return';
    protected $description = 'Verstuur herinneringen voor uitleenitems waarvan de inleverdatum nadert';

    public function handle(): int
    {
        $targetDate = now()->addDays(1)->toDateString();

        $loans = Uitleen::with(['user', 'hardware'])
            ->where('status', 'approved')
            ->whereDate('end_date', $targetDate)
            ->whereNull('reminder_sent_at')
            ->get();

        foreach ($loans as $loan) {
            if (!$loan->user || !$loan->user->email) {
                continue;
            }

            Mail::to($loan->user->email)->send(new ReturnReminderMail($loan));

            $loan->update([
                'reminder_sent_at' => now(),
            ]);
        }

        $this->info("{$loans->count()} herinnering(en) verstuurd.");

        return self::SUCCESS;
    }
}