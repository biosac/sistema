@extends('principal')
@section('contenido')
    <template v-if="menu==0">
        <categoria></categoria>
    </template>
    <template v-if="menu==1">
        <example-component></example-component>
    </template>
@endsection