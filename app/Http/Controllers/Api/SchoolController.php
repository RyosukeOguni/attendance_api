<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\School;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\FilterMapper;

class SchoolController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $schools = School::all()->toArray();
    $schools = array_map(function ($school) {
      return $school['school_name'];
    }, $schools);
    return response()->json($schools);
  }
}
