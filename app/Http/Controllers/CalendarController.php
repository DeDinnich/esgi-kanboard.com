<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Eluceo\iCal\Domain\Entity\Calendar as ICalendar;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\DateTime as ICalDateTime;
use Eluceo\iCal\Domain\ValueObject\TimeZone;

class CalendarController extends Controller
{
    public function show(Project $project)
    {
        $project->load([
            'columns' => fn($q) => $q->orderBy('order'),
            'columns.tasks' => fn($q) => $q->orderBy('date_limite'),
            'columns.tasks.collaborateurs',
            'columns.tasks.creator',
        ]);

        return view('pages.project.calendar', compact('project'));
    }

    public function getTasks(Project $project, Request $request)
    {
        try {
            Log::info('Validating request for fetching tasks.', [
                'project_id' => $project->id,
                'start' => $request->start,
                'end' => $request->end,
            ]);

            $request->validate([
                'start' => 'required|date',
                'end' => 'required|date|after_or_equal:start',
            ]);

            Log::info('Request validation successful.', [
                'project_id' => $project->id,
                'start' => $request->start,
                'end' => $request->end,
            ]);

            $tasks = Task::whereHas('column', function ($q) use ($project) {
                $q->where('project_id', $project->id);
            })
            ->whereBetween('date_limite', [$request->start, $request->end])
            ->with(['creator', 'collaborateurs'])
            ->get();

            Log::info('Tasks fetched successfully.', [
                'project_id' => $project->id,
                'task_count' => $tasks->count(),
            ]);

            return response()->json($tasks);
        } catch (\Exception $e) {
            Log::error('Error fetching tasks: ' . $e->getMessage(), [
                'project_id' => $project->id,
                'start' => $request->start,
                'end' => $request->end,
                'exception' => $e,
            ]);

            return response()->json(['error' => 'An error occurred while fetching tasks.'], 500);
        }
    }

    public function generateIcal(Project $project)
    {
        try {
            Log::info('Generating iCal for project.', ['project_id' => $project->id]);

            $tasks = Task::whereHas('column', fn ($q) => $q->where('project_id', $project->id))->get();

            $calendar = new ICalendar();

            foreach ($tasks as $task) {
                if (!$task->date_limite) continue;

                $event = new Event();
                $event->setSummary($task->nom ?? 'Tâche sans nom');
                $event->setDescription($task->description ?? '');
                $event->setOccurrence(new \Eluceo\iCal\Domain\ValueObject\SingleDay(
                    new \Eluceo\iCal\Domain\ValueObject\Date(new \DateTime($task->date_limite))
                ));
                $calendar->addEvent($event);
            }

            $componentFactory = new CalendarFactory();
            $calendarComponent = $componentFactory->createCalendar($calendar);

            Log::info('iCal generated successfully.', ['project_id' => $project->id]);

            return Response::make($calendarComponent, 200, [
                'Content-Type' => 'text/calendar',
                'Content-Disposition' => 'attachment; filename=kanboard-'.$project->id.'.ics',
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating iCal: ' . $e->getMessage(), [
                'project_id' => $project->id,
                'exception' => $e,
            ]);

            return response()->json(['error' => 'An error occurred while generating the iCal file.'], 500);
        }
    }
}
