@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar" style="background-color: #F4F4F4; min-height: 100vh; padding: 20px;">
      <div class="title" style="font-size: 24px; color: #000; margin-bottom: 30px; display: flex; align-items: center;">
        <i class="fas fa-user-shield" style="margin-right: 10px; font-size: 28px;"></i> Administrador
      </div>
      <div class="menu">
        <a href="{{ route('admin.dashboard') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Home
        </a>
        <a href="{{ route('admin.estadisticas') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Estadísticas
        </a>
        <a href="{{ route('admin.actividades.listar') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Actividades
        </a>
        <a href="{{ route('admin.clientes.listar') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Clientes
        </a>
        <a href="{{ route('admin.citas.listar') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Citas
        </a>
        <a href="{{ route('admin.entrenadores.listar') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Entrenadores
        </a>
      </div>
    </div>

    <!-- Contenido principal: Google Calendar -->
    <div class="col-md-10">
      <div class="container mt-4">
        <h2>Calendario</h2>
        <!-- Reemplaza el src con el enlace a tu calendario de Google -->
        <iframe src="https://calendar.google.com/calendar/embed?src=TU_EMAIL%40ejemplo.com&ctz=Europe%2FMadrid" 
                style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
      </div>
    </div>
  </div>
</div>
@endsection