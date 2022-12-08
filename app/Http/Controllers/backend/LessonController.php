<?php

namespace App\Http\Controllers\backend;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.lesson.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'lesson_title'   => ['required', 'string', 'max:255'],
            'lesson_content' => ['required', 'not_in:none'],
            'status'         => ['required', 'not_in:none'],
            'course_id'      => ['required', 'string', 'max:255'],
        ]);

        try {
            Lesson::create([
                'name'      => $request->lesson_title,
                'slug'      => Str::slug($request->lesson_title),
                'content'   => $request->lesson_content,
                'status'    => $request->status,
                'course_id' => $request->course_id,
            ]);

            return redirect()->route('course.index')->with('success', "Lesson Added Successfully!");
        } catch (\Throwable $th) {
            return redirect()->route('course.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        return view('backend.lesson.edit')->with([
            'lesson'  => $lesson,
            'courses' => Course::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'lesson_title'   => ['required', 'string', 'max:255'],
            'lesson_content' => ['required', 'not_in:none'],
            'status'         => ['required', 'not_in:none'],
            'course_id'      => ['required', 'string', 'max:255'],
        ]);

        try {
            $lesson->update([
                'name'      => $request->lesson_title,
                'slug'      => Str::slug($request->lesson_title),
                'content'   => $request->lesson_content,
                'status'    => $request->status,
                'course_id' => $request->course_id,
            ]);

            return redirect()->route('course.index')->with('success', "Lesson Updated Successfully!");
        } catch (\Throwable $th) {
            return redirect()->route('course.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->back()->with('success', "Lesson Deleted");
    }
}
