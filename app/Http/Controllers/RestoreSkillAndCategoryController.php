<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\restoreSkillAndCategory;
use App\Models\Skill;
use Illuminate\Http\Request;

class RestoreSkillAndCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('skill.restoreSkillAndCategory', [
            'skills' => Skill::onlyTrashed()->with('category')->get(),
            'categories' => Category::onlyTrashed()->get(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function restore(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'skill' => 'array', // pastikan skill adalah array
            'skill.*' => 'exists:skills,id', // pastikan setiap skill valid di tabel skills
            'category' => 'array', // pastikan category adalah array
            'category.*' => 'exists:categories,id', // pastikan setiap category valid di tabel categories
        ]);

        // Ambil semua category yang ingin di-restore
        $restoredCategories = isset($validated['category']) ? $validated['category'] : [];

        $errorMessages = []; // Simpan pesan error di sini

        if (isset($validated['skill'])) {
            // Ambil skill yang soft-deleted
            $skills = Skill::onlyTrashed()->whereIn('id', $validated['skill'])->get();
    
            foreach ($skills as $skill) {
                // Cek apakah kategori dari skill sudah ada (baik tidak terhapus ataupun terhapus)
                $categoryExists = Category::where('id', $skill->category_id)->exists();
    
                if (!$categoryExists) {
                    // Jika kategori terkait tidak ada sama sekali, hapus skill secara permanen (hard delete)
                    $errorMessages[] = "Skill '{$skill->name}' Restore failed because the related category was not found.";
                } else {
                    // Jika kategori terkait ada (baik terhapus maupun tidak), restore skill
                    $skill->restore();
                }
            }

        // Restore category jika ada input category yang di-restore
        if (isset($validated['category'])) {
            $categories = Category::onlyTrashed()->whereIn('id', $validated['category'])->get();

            foreach ($categories as $category) {
                $category->restore();
            }
        }

        // Cek jika ada pesan error
        if (!empty($errorMessages)) {
            // Redirect kembali dengan pesan error
            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        // Jika tidak ada error, berikan pesan sukses
        return redirect()->back()->with('success', 'Selected skills or categories processed successfully!');
    }
    }
    /**
     * Display the specified resource.
     */
    public function show(restoreSkillAndCategory $restoreSkillAndCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(restoreSkillAndCategory $restoreSkillAndCategory)
    {
        //
    }
}
