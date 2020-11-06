@extends('common_layouts')
@section('content')
<form action="/">
        <h1>User Registration Form</h1>
        <div class="info">
          <input class="fname" type="text" name="Username" required placeholder="Username">
          <input type="email" name="Email" required placeholder="Email">
          <input type="text" name="FirstName" required placeholder="FirstName">
          <input type="text" name="LastName" required placeholder="LastName">
        </div>
        <!-- <p>Message</p>
        <div>
          <textarea rows="4"></textarea>
        </div> -->
        <button type="submit" >Submit</button>
      </form>
      @endsection