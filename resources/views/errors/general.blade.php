@extends('errors.minimal')

@section('title', 'Error')
@section('coed', '')
@section('message', $exception->getMessage())
