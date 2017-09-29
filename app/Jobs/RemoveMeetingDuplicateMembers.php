<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RemoveMeetingDuplicateMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $meeting;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Meeting $meeting)
    {
        $this->meeting = $meeting;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $keys = $this->meeting->members->modelKeys();
        $members = \App\Member::find($keys);
        $this->meeting->members()->detach();
        $this->meeting->members()->saveMany($members);
    }
}
