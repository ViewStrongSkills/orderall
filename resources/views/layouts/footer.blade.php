<footer class="footer">
    <div class="container">
        <a title="Orderall" href="{{route('main')}}" class="footer_logo"><img alt="Orderall logo" src="{{ asset('images/logo-gray.svg') }}"></a>
        <ul class="footer_links">
        <li><a title="Orderall for your business" href="{{URL::to('business-about')}}">Orderall for your business</a></li>
        <li><a title="Request business" href="{{URL::to('requestbusiness')}}">Request a business to be added</a></li>
        <li><a title="Help" href="{{URL::to('help')}}">Help</a></li>
        <li><a title="Contact" href="{{URL::to('contact')}}">Contact</a></li>
        <li><a title="Terms of Service" href="{{URL::to('tos')}}">Terms of Service</a></li>
        <li><a title="Privacy Policy" href="{{URL::to('privacy')}}">Privacy Policy</a></li>
        {{--<li><a title="About" href="{{URL::to('about')}}">About</a></li>--}}
        </ul>
        <ul class="media_icon">
        <li><a title="Facebook" href="{{URL::to('https://www.facebook.com/OrderallApp')}}"><img src="{{asset('images/facebook.svg')}}" class="fa fa-facebook" alt="Facebook"></a></li>
        <li><a title="Twitter" href="{{URL::to('https://www.twitter.com/OrderallApp')}}"><img src="{{asset('images/twitter.svg')}}" class="fa fa-twitter" alt="Twitter"></a></li>
        <li><a title="Instagram" href="{{URL::to('https://www.instagram.com/OrderallApp/')}}"><img src="{{asset('images/instagram.svg')}}" class="fa fa-instagram" alt="Instagram"></a></li>
        {{--<li><a href="{{URL::to('http://www.snapchat.com')}}"><img src="{{asset('images/snapchat-ghost.svg')}}" class="fa fa-snapchat-ghost"></i></a></li>--}}
        </ul>
        <div class="copy_right">&copy; 2018 Orderall. All rights reserved. </div>
    </div>

</footer>
