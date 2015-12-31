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
                                'id'=>'register-form', 'novalidate'=>'novalidate' ]) !!}
                                <div class="sminputs">
                                    <div class="input full">
                                        <label class="string optional" for="user-email">Email*</label>
                                        <input class="string optional" maxlength="100" id="user-email"
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
                                    <div class="input full">
                                        <label class="string optional" for="user-from_refer">From Refer ( <span class="special">For Both Social Network and Site</span> )</label>
                                        <input class="string optional" maxlength="20" id="user-from_refer"
                                               placeholder="From Refer" type="text" size="50" name="register[from_refer]"/>
                                    </div>
                                </div>
                                <div class="simform__actions">
                                    <button class="submit" name="commit" type="submit"/>
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
                                        <div class="connect__context">
                                            <span onclick='window.location="{{ $daily['url_join'] }}"'>Create an account with <strong>Dailymotion</strong></span>
                                        </div>
                                    </a>

                                    <a href="#" class="connect facebook">
                                        <div class="connect__icon">
                                            <i class="fa fa-facebook"></i>
                                        </div>
                                        <div class="connect__context">
                                            <span>Create an account with <strong>Facebook</strong></span>
                                        </div>
                                    </a>

                                    <a href="#" class="connect googleplus">
                                        <div class="connect__icon">
                                            <i class="fa fa-google-plus"></i>
                                        </div>
                                        <div class="connect__context">
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
                            </div>
                            <div class="logmod__form">
                                <form accept-charset="utf-8" action="#" class="simform">
                                    <div class="sminputs">
                                        <div class="input full">
                                            <label class="string optional" for="user-name">Email*</label>
                                            <input class="string optional" maxlength="255" id="user-email"
                                                   placeholder="Email" type="email" size="50"/>
                                        </div>
                                    </div>
                                    <div class="sminputs">
                                        <div class="input full">
                                            <label class="string optional" for="user-pw">Password *</label>
                                            <input class="string optional" maxlength="255" id="user-pw"
                                                   placeholder="Password" type="password" size="50"/>
                                            <span class="hide-password">Show</span>
                                        </div>
                                    </div>
                                    <div class="simform__actions">
                                        <input class="submit" name="commit" type="submit" value="Log In"/>
                                        <span class="simform__actions-sidetext"><a class="special" role="link" href="#">Forgot
                                                your password?<br>Click here</a></span>
                                    </div>
                                </form>
                            </div>
                            <div class="logmod__alter">
                                <div class="logmod__alter-container">
                                    <a href="#" class="connect dailymotion">
                                        <div class="connect__icon">
                                            <i class="fa"></i>
                                        </div>
                                        <div class="connect__context">
                                            <span>Sign in with <strong>Dailymotion</strong></span>
                                        </div>
                                    </a>
                                    <a href="#" class="connect facebook">
                                        <div class="connect__icon">
                                            <i class="fa fa-facebook"></i>
                                        </div>
                                        <div class="connect__context">
                                            <span>Sign in with <strong>Facebook</strong></span>
                                        </div>
                                    </a>
                                    <a href="#" class="connect googleplus">
                                        <div class="connect__icon">
                                            <i class="fa fa-google-plus"></i>
                                        </div>
                                        <div class="connect__context">
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