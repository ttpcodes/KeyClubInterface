<?php

namespace App\Jobs;

use App\Meeting;
use App\Member;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Log;

class UpdateMeetingMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $meeting;
    protected $members;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Meeting $meeting, array $members)
    {
        $this->meeting = $meeting;
        $this->members = $members;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Filter out anything that isn't a number to prevent database errors.
        $this->members = array_filter($this->members, function ($id) {
            return is_numeric($id);
        });
        // Removes all existing members from the array to leave new members.
        $newMembers = array_diff($this->members, $this->meeting->members->modelKeys());
        // Removes all new members from the array to leave duplicate members.
        $duplicate = array_diff($this->members, $newMembers);
        Log::info("Reduced " . count($this->members) . " to " . count($newMembers) . " new member entries");
        $members = Member::find($newMembers);
        Log::info($members->count() . " found out of " . count($newMembers));

        $missing = array_diff($newMembers, $members->modelKeys(), $this->meeting->missing_members->modelKeys());
        $this->meeting->members()->saveMany($members);
        if (count($missing) != 0) {
            $data = array();
            foreach ($missing as $id) {
                $data[] = array(
                    "id" => $id,
                    "meeting_id" => $this->meeting->id
                );
            }
            $this->meeting->missing_members()->createMany($data);
        }
    }
}
