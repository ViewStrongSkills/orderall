@extends('layouts.master')

@section('page-title', 'How to set up your Orderall page')
@section('content')
    <div class="middle-contact business-guide">
    <div class="container">
    <div class="page-head-content">
    <h2>Guide for businesses setting up their page</h2>
    </div>
    <br>
    <div class="row">
      <div class="col-md">
        <div class="works_box">
          <span>1</span>
          <div class="clearfix"></div>
          <img src="{{ asset('images/business-guide/signup.jpg')}}" style="width:100%;" alt="Create account">
          <h6>Create an account by clicking on "Business Signup"</h6>
        </div>
      </div>
      <div class="col-md">
        <div class="works_box">
          <span>2</span>
          <div class="clearfix"></div>
          <img src="{{ asset('images/business-guide/email.jpg')}}" style="width:100%;" alt="Add business page">
          <h6>When your application has been accepted you'll receive an email confirmation</h6>
        </div>
      </div>
      <div class="col-md">
        <div class="works_box">
          <span>3</span>
          <div class="clearfix"></div>
          <img src="{{ asset('images/business-guide/addbusiness.jpg')}}" style="width:100%;" alt="View business">
          <h6>Use the "create business" page to add a page for your business</h6>
        </div>
      </div>
      <div class="col-md">
        <div class="works_box">
          <span>4</span>
          <div class="clearfix"></div>
          <img src="{{ asset('images/business-guide/ophours.jpg')}}" style="width:100%;" alt="Add menus">
          <h6>Add new menus</h6>
        </div>
      </div>
      <div class="col-md">
        <div class="works_box">
          <span>5</span>
          <div class="clearfix"></div>
          <img src="{{ asset('images/business-guide/item.jpg')}}" style="width:100%;" alt="Add items">
          <h6>Add items to the menus</h6>
        </div>
      </div>
      <div class="col-md">
        <div class="works_box">
          <span>6</span>
          <div class="clearfix"></div>
          <img src="{{ asset('images/business-guide/extras.jpg')}}" style="width:100%;" alt="Add extras">
          <h6>Add extras to your items</h6>
        </div>
      </div>
    </div>

    </div>
    </div>
@endsection
