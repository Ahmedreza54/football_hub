<?php

namespace App\Console\Commands;

use App\Models\FootballMatch;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendMatchReminders extends Command
{
    protected $signature = 'app:send-match-reminders';

    protected $description = 'Process reminders one hour before scheduled matches';

    public function handle(): int
    {
        $now = now();

        // Retrieve scheduled matches and compare their dates using Carbon.
        $matches = FootballMatch::where('status', 'Scheduled')->get()
            ->filter(function ($match) use ($now) {
                $kickoff = Carbon::parse($match->match_date);

                return $kickoff->gt($now)
                    && $kickoff->lte($now->copy()->addHour());
            });

        $remindersCreated = 0;

        foreach ($matches as $match) {
            $reminderAt = Carbon::parse($match->match_date)->subHour();

            $reminder = DB::table('match_reminders')
                ->where('match_id', $match->id)
                ->first();

            if (!$reminder) {
                DB::table('match_reminders')->insert([
                    'match_id' => $match->id,
                    'reminder_at' => $reminderAt,
                    'sent_at' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                $reminder = DB::table('match_reminders')
                    ->where('match_id', $match->id)
                    ->first();

                $remindersCreated++;
            }

            if (
                $reminder &&
                $reminder->sent_at === null &&
                Carbon::parse($reminder->reminder_at)->lte($now)
            ) {
                DB::table('match_reminders')
                    ->where('id', $reminder->id)
                    ->update([
                        'sent_at' => $now,
                        'updated_at' => $now,
                    ]);

                $this->info('Reminder processed for match ID: ' . $match->id);
            }
        }

        $this->info("New reminder records created: {$remindersCreated}");

        return self::SUCCESS;
    }
}
