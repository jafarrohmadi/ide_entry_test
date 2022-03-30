<?php

Class School extends Model{
    protected $table = 'school';
    protected $fillable = ['school_code', 'school_name', 'inaugurated_date'];
}

Class SchoolController extends Controller
{
    public function index()
    {
        $from = date('2020-01-01');
        $to = date('2020-01-30');

        return School::whereBetween('reservation_from', [$from, $to])->get();
    }
}
