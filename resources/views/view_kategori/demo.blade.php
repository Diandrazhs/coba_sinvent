//memasukan tamplate master di folder layouts
@extends('layouts.master')

//memasukan data  demo pada yield content
@section('content')
@forelse ( $rsetCategory as $rowCategory)
    {{ $rowCategory->id }}
    {{$rowCategory->deskripsi}}
    {{$rowCategory->kategori}}
@empty
    {{"kosong"}}
@endforelse
@endsection