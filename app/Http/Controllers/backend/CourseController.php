<?php

namespace App\Http\Controllers\backend;

use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::where('teacher_id', Auth::user()->id)->orderBy('id','ASC')->paginate(20);
        return view('backend.course.index')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.course.create')->with([
            'categories' => Category::orderBy('name','ASC')->get(),
        ]);
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
            'name'        => ['required', 'string', 'max:255'],
            'status'      => ['required', 'not_in:none'],
            'level'       => ['required', 'not_in:none'],
            'category_id' => ['required', 'not_in:none'],
        ]);

        try {
            $thumbnail = null;
            if (!empty($request->file('thumbnail'))) {
                $thumbnail = time() . '-' . $request->file('thumbnail')->getClientOriginalName();
                $request->file('thumbnail')->storeAs('public/uploads', $thumbnail);
            }

            Course::create([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'thumbnail'   => $thumbnail,
                'side_note'   => $request->side_note,
                'status'      => $request->status,
                'level'       => $request->level,
                'category_id' => $request->category_id,
                'teacher_id'  => Auth::user()->id,
            ]);

            return redirect()->route('course.index')->with('success', "Course Added Successfully!");
        } catch (\Throwable $th) {
            return redirect()->route('course.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('backend.course.edit')->with([
            'course'    => $course,
            'categories' => Category::orderBy('name','ASC')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'status'      => ['required', 'not_in:none'],
            'level'       => ['required', 'not_in:none'],
            'category_id' => ['required', 'not_in:none'],
        ]);

        try {
            $thumbnail = $course->thumbnail;

            if ( !empty($request->file('thumbnail')) ) {
                Storage::delete('public/uploads/'.$thumbnail);

                $thumbnail = time() . '-' . $request->file('thumbnail')->getClientOriginalName();
                $request->file('thumbnail')->storeAs('public/uploads', $thumbnail);
            }

            $course->update([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'thumbnail'   => $thumbnail,
                'side_note'   => $request->side_note,
                'status'      => $request->status,
                'level'       => $request->level,
                'category_id' => $request->category_id,
                'teacher_id'  => Auth::user()->id,
            ]);

            return redirect()->route('course.index')->with('success', "Course Updated Successfully!");
        } catch (\Throwable $th) {
            return redirect()->route('course.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        Storage::delete('public/uploads/'.$course->thumbnail);
        $course->delete();
        return redirect()->route('course.index')->with('success', "Course Deleted");
    }
}
