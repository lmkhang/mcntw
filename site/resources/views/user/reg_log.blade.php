<div class="modal fade" id="joinus_modal" role="dialog" xmlns="http://www.w3.org/1999/html">
    <div class="modal-dialog">

        <div class="logmod">
            <div class="logmod__wrapper">
                <span class="logmod__close close" data-dismiss="modal">Close</span>

                <div class="logmod__container">
                    <ul class="logmod__tabs">
                        <li data-tabtar="lgm-2"><a href="#">Login</a></li>
                        <li data-tabtar="lgm-1"><a href="#">Sign Up</a></li>
                    </ul>
                    <div class="logmod__tab-wrapper">
                        <div class="logmod__tab lgm-1">
                            <div class="logmod__heading">
                                <span class="logmod__heading-subtitle">Enter your personal details <strong>to create an
                                        acount</strong></span>
                                <label class="common_message"></label>
                            </div>
                            <div class="logmod__form">
                                {!! Form::open(['url'=>'/register', 'method'=>'post', 'name'=>'register',
                                'id'=>'register-form', 'novalidate'=>'novalidate', 'class'=>'simform' ]) !!}
                                <div class="sminputs">
                                    <div class="input full">
                                        <label class="string optional" for="user-name">Username*</label>
                                        <input class="string optional" maxlength="100" id="user-name"
                                               placeholder="Username" type="text" size="50" name="register[username]"/>
                                    </div>
                                </div>
                                <div class="sminputs">
                                    <div class="input full">
                                        <label class="string optional" for="user-email">Email*</label>
                                        <input class="string optional" maxlength="100" id="user-email" autocomplete="off"
                                               placeholder="Email" type="email" size="50" name="register[email]"/>
                                    </div>
                                </div>
                                <div class="sminputs">
                                    <div class="input string optional">
                                        <label class="string optional" for="user-pw">Password *</label>
                                        <input class="string optional" maxlength="50" id="user-pw"
                                               placeholder="Password" type="password" size="50"
                                               name="register[password]"/>
                                    </div>
                                    <div class="input string optional">
                                        <label class="string optional" for="user-pw-repeat">Repeat password
                                            *</label>
                                        <input class="string optional" maxlength="50" id="user-pw-repeat"
                                               placeholder="Repeat password" type="password" size="50"
                                               name="register[repeat_password]"/>
                                    </div>
                                </div>
                                <div class="sminputs">
                                    <div class="input string optional">
                                        <label class="string optional" for="user-firstname">First Name *</label>
                                        <input class="string optional" maxlength="50" id="user-firstname"
                                               placeholder="First Name" type="text" size="50"
                                               name="register[first_name]"/>
                                    </div>
                                    <div class="input string optional">
                                        <label class="string optional" for="user-lastname">Last Name
                                            *</label>
                                        <input class="string optional" maxlength="50" id="user-lastname"
                                               placeholder="Last Name" type="text" size="50"
                                               name="register[last_name]"/>
                                    </div>
                                </div>
                                <div class="sminputs">
                                    <div class="input string optional">
                                        <label class="string optional" for="user-pin_code">Pin Code *</label>
                                        <input class="string optional qtyInput" maxlength="6" id="user-pin_code"
                                               placeholder="Pin Code" type="password" size="6" readonly
                                               name="register[pin_code]"/>
                                    </div>
                                    <div class="input string optional">
                                        <label class="string optional" for="user-from_refer">From Refer</label>
                                        <input class="string optional" maxlength="20" id="user-from_refer"
                                               value="{{$refer}}" readonly
                                               placeholder="From Refer" type="text" size="20"
                                               name="register[from_refer]"/>
                                    </div>
                                </div>
                                <div class="simform__actions">
                                    <button class="submit register" name="commit" type="submit"/>
                                    Create Account</button>
                                        <span class="simform__actions-sidetext">By creating an account you agree to our <a
                                                    class="special" href="/download/contract_mcn_28_12_2015.pdf"
                                                    target="_blank" role="link">Terms &
                                                Privacy</a></span>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="logmod__alter">
                                <div class="logmod__alter-container">
                                    <a href="#" class="connect dailymotion">
                                        <div class="connect__icon">
                                            <i class="fa"></i>
                                        </div>
                                        <div class="connect__context" onclick='window.location="{{ $daily['url_join'] }}"'>
                                            <span>Create an account with <strong>Dailymotion</strong></span>
                                        </div>
                                    </a>

                                    <a href="#" class="connect facebook">
                                        <div class="connect__icon">
                                            <i class="fa fa-facebook"></i>
                                        </div>
                                        <div class="connect__context" onclick='logInWithFacebook();'>
                                            <span>Create an account with <strong>Facebook</strong></span>
                                        </div>
                                    </a>

                                    <a href="#" class="connect googleplus">
                                        <div class="connect__icon">
                                            <i class="fa fa-google-plus"></i>
                                        </div>
                                        <div class="connect__context" onclick='window.location="{{ $google['url_join'] }}"'>
                                            <span>Create an account with <strong>Google+</strong></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="logmod__tab lgm-2">
                            <div class="logmod__heading">
                                <span class="logmod__heading-subtitle">Enter your email and password <strong>to sign
                                        in</strong></span>
                                <label class="common_message_login"></label>
                            </div>
                            <div class="logmod__form">
                                {!! Form::open(['url'=>'/login', 'method'=>'post', 'name'=>'login',
                                'id'=>'login-form', 'novalidate'=>'novalidate', 'class'=>'simform' ]) !!}
                                <div class="sminputs">
                                    <div class="input full">
                                        <label class="string optional" for="user-name-email">Username or Email*</label>
                                        <input class="string optional" maxlength="255" id="user-name-email" autocomplete="off"
                                               placeholder="Username or Email" type="text" name="login[account]" size="100"/>
                                    </div>
                                </div>
                                <div class="sminputs">
                                    <div class="input full">
                                        <label class="string optional" for="user-pw">Password *</label>
                                        <input class="string optional" maxlength="255" id="user-password"
                                               placeholder="Password" type="password" name="login[password]" size="50"/>
                                        <span class="hide-password">Show</span>
                                    </div>
                                </div>
                                <div class="simform__actions">
                                    <button class="submit login" name="commit" type="submit"/>
                                    Log In</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="logmod__form">
                                {!! Form::open(['url'=>'/forgot', 'method'=>'post', 'name'=>'forgot',
                                'id'=>'forgot-form', 'validate'=>'validate', 'class'=>'simform' ]) !!}
                                <div class="sminputs">
                                    <div class="input full">
                                        <label class="string optional" for="forgot-email">Email*</label>
                                        <input class="string optional" maxlength="255" id="forgot-email"
                                               placeholder="Email" type="text" name="forgot[email]" size="100"/>
                                    </div>
                                </div>
                                <div class="simform__actions">
                                    <button class="submit forgot" name="commit" type="submit"/>
                                    Forgot your password?</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="logmod__alter">
                                <div class="logmod__alter-container">
                                    <a href="#" class="connect dailymotion">
                                        <div class="connect__icon">
                                            <i class="fa"></i>
                                        </div>
                                        <div class="connect__context" onclick='window.location="{{ $daily['url_join'] }}"'>
                                            <span>Sign in with <strong>Dailymotion</strong></span>
                                        </div>
                                    </a>
                                    <a href="#" class="connect facebook">
                                        <div class="connect__icon">
                                            <i class="fa fa-facebook"></i>
                                        </div>
                                        <div class="connect__context" onclick='logInWithFacebook();'>
                                            <span>Sign in with <strong>Facebook</strong></span>
                                        </div>
                                    </a>
                                    <a href="#" class="connect googleplus">
                                        <div class="connect__icon">
                                            <i class="fa fa-google-plus"></i>
                                        </div>
                                        <div class="connect__context" onclick='window.location="{{ $google['url_join'] }}"'>
                                            <span>Sign in with <strong>Google+</strong></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    //FB
    logInWithFacebook = function() {
        FB.login(function(response) {
            if (response.authResponse) {
                window.location = '{{$fbook['url_callback'] }}';
            } else {
                alert('User cancelled login or did not fully authorize.');
            }
        });
        return false;
    };
    window.fbAsyncInit = function() {
        FB.init({
            appId: '{{$fbook['api_key']}}',
            status     : true,
            cookie     : true,
            xfbml      : true,
            version: 'v2.5'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>