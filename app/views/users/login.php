<!DOCTYPE html>
<html lang="en-US" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Settle Matter :: Sign In</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="<?=URLROOT?>/images/logo/settle-icon1.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?=URLROOT?>/images/logo/settle-icon1.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?=URLROOT?>/images/logo/settle-icon1.png" />
    <link rel="shortcut icon" type="image/x-icon" href="<?=URLROOT?>/images/logo/settle-icon1.png" />
    <script src="<?=URLROOT?>/assets/user-assets/vendors/simplebar/simplebar.min.js"></script>
    <script src="<?=URLROOT?>/assets/user-assets/js/config.js"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link href="<?=URLROOT?>/assets/user-assets/vendors/simplebar/simplebar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../../../../unicons.iconscout.com/release/v4.0.8/css/line.css" />
    <link href="<?=URLROOT?>/assets/user-assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet"
        id="style-rtl" />
    <link href="<?=URLROOT?>/assets/user-assets/css/theme.min.css" type="text/css" rel="stylesheet"
        id="style-default" />
    <link href="<?=URLROOT?>/assets/user-assets/css/user-rtl.min.css" type="text/css" rel="stylesheet"
        id="user-style-rtl" />
    <link href="<?=URLROOT?>/assets/user-assets/css/user.min.css" type="text/css" rel="stylesheet"
        id="user-style-default" />
    <link rel="stylesheet" href="<?=URLROOT?>/css/font-awesome/css/all.css" />
    <script>
    var phoenixIsRTL = window.config.config.phoenixIsRTL;
    if (phoenixIsRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.gextElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
    } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
    }
    </script>
</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid bg-body-tertiary dark__bg-gray-1200">
            <div class="bg-holder bg-auth-card-overlay" style="background-color: rgb(243 233 210)"></div>
            <!--/.bg-holder-->
            <div class="row flex-center position-relative min-vh-100 g-0 py-5">
                <div class="col-11 col-sm-10 col-xl-6">
                    <div class="card border border-translucent auth-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col col-md-12">
                                    <div class="">
                                        <?= flash('flash_message'); ?>
                                        <div class="">
                                            <a class="d-flex flex-center text-decoration-none mb-4" href="index.html">
                                                <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block">
                                                    <img src="<?=URLROOT?>/images/logo/settle-matter-dark.png"
                                                        alt="phoenix" width="120" />
                                                </div>
                                            </a>
                                            <h3 class="text-body-highlight">Sign In</h3>
                                            <p class="text-body-tertiary">
                                                Get access to your account
                                            </p>
                                        </div>

                                        <div class="position-relative">
                                            <hr class="bg-body-secondary mt-5 mb-4" />
                                            <div class="divider-content-center bg-body-emphasis">
                                                use email
                                            </div>
                                        </div>
                                        <form action="<?=URLROOT?>/users/login" method="POST">
                                            <div class="mb-3 text-start auth">
                                                <input type="hidden" name="csrf_token"
                                                    value="<?= htmlspecialchars($data['csrf_token'] ?? '') ?>">
                                                <label class="form-label" for="email">Email address</label>
                                                <div class="form-icon-container auth-input">
                                                    <input type="email"
                                                        class="form-control form-icon-input <?= !empty($data['errors']['email']) ? 'is-invalid' : ''; ?>"
                                                        name="email" placeholder="Enter Your Email"
                                                        value="<?= htmlspecialchars($data['email']); ?>" required>
                                                    <span class="fas fa-message text-body fs-9 form-icon"></span>
                                                </div>
                                                <span
                                                    class="invalid-feedback"><?= $data['errors']['email'] ?? ''; ?></span>
                                            </div>
                                            <div class="mb-3 text-start auth">
                                                <label class="form-label" for="password">Password</label>
                                                <div class="form-icon-container auth-input"
                                                    data-password="data-password">
                                                    <input
                                                        class="form-control form-icon-input pe-6 <?= !empty($data['errors']['password']) ? 'is-invalid' : ''; ?>"
                                                        id="
                                                        password" type="password" placeholder="Password"
                                                        name="password"
                                                        data-password-input="data-password-input" /><span
                                                        class="fas fa-key text-body fs-9 form-icon"></span>
                                                    <button type="button"
                                                        class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                                        data-password-toggle="data-password-toggle">
                                                        <i class="fas fa-eye show"
                                                            style="color: grey; font-size: 12px"></i><i
                                                            style="color: grey; font-size: 12px"
                                                            class="fas fa-eye-slash hide"></i>
                                                    </button>
                                                </div>
                                                <span
                                                    class="invalid-feedback"><?= $data['errors']['password'] ?? ''; ?></span>
                                            </div>
                                            <div class="row flex-between-center mb-7">
                                                <div class="col-auto">
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" id="basic-checkbox"
                                                            type="checkbox" checked="checked" /><label
                                                            class="form-check-label mb-0" for="basic-checkbox">Remember
                                                            me</label>
                                                    </div>
                                                </div>
                                                <div class="col-auto auth-forgot">
                                                    <a class="fs-9 fw-semibold" href="forgot-password.html">Forgot
                                                        Password?</a>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100 mb-3 auth-btn">
                                                Sign In
                                            </button>
                                            <div class="text-center auth-create">
                                                <a class="fs-9 fw-bold" href="<?=URLROOT?>/users/register">Create an
                                                    account</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="<?=URLROOT?>/assets/user-assets/vendors/popper/popper.min.js"></script>
    <script src="<?=URLROOT?>/assets/user-assets/vendors/bootstrap/bootstrap.min.js">
    </script>
    <script src="<?=URLROOT?>/assets/user-assets/vendors/anchorjs/anchor.min.js">
    </script>
    <script src="<?=URLROOT?>/assets/user-assets/vendors/is/is.min.js">
    </script>
    <script src="<?=URLROOT?>/assets/user-assets/vendors/fontawesome/all.min.js">
    </script>
    <script src="<?=URLROOT?>/assets/user-assets/vendors/lodash/lodash.min.js">
    </script>
    <script src="<?=URLROOT?>/assets/user-assets/vendors/list.js/list.min.js">
    </script>
    <script src="<?=URLROOT?>/assets/user-assets/vendors/feather-icons/feather.min.js">
    </script>
    <script src="<?=URLROOT?>/assets/user-assets/vendors/dayjs/dayjs.min.js">
    </script>
    <script src="<?=URLROOT?>/assets/user-assets/js/phoenix.js"></script>
</body>

</html>