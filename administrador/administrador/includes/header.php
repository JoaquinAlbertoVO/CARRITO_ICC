<?php  

if (empty($_SESSION['active'])) {
    header('location: ../');
}

?>
<!-- Header -->

        <div id="header" class="mdk-header js-mdk-header m-0" data-fixed>
            <div class="mdk-header__content">

                <div class="navbar navbar-expand-sm navbar-main navbar-dark bg-primary pl-md-0 pr-0" id="navbar" data-primary>
                    <div class="container-fluid pr-0 ">

                        <!-- Navbar toggler -->
                        <button class="navbar-toggler navbar-toggler-custom d-lg-none d-flex mr-navbar" type="button" data-toggle="sidebar">
                            <span class="material-icons">short_text</span>
                        </button>


                        <div class="d-flex sidebar-account flex-shrink-0 mr-auto mr-lg-0">
                            <a href="./" class="flex d-flex align-items-center text-underline-0">
                                <span class="mr-1  text-white">
                                    <!-- LOGO -->
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 40" width="30" height="30">
                                        <g transform="matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)">
                                            <img width="170" src="<?php echo isset($base_path) ? $base_path : \'\'; ?>assets/images/favicons/icc-logo1.png" alt="ICC">
                                        </g>
                                    </svg>
                                </span>
                                <span class="flex d-flex flex-column text-white">
                                    <strong class="sidebar-brand"></strong>
                                </span>
                            </a>
                        </div>

                        <ul class="nav navbar-nav d-none d-lg-flex pl-2">
                            <li class="nav-item dropdown">
                                <a href="./" class="nav-link dropdown-toggle" data-toggle="dropdown" data-caret="false">
                                    <span class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 40" width="22" height="22">
                                            <g transform="matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)">
                                                <?php  
                                                if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                                                    ?>
                                                    <img width="150" src="<?php echo isset($base_path) ? $base_path : \'\'; ?>assets/images/favicons/icc-logo-electrica.png" alt="ICC-electrica">
                                                    <?php 
                                                }
                                                ?>
                                                <?php  
                                                if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) {
                                                    ?>
                                                    <img width="150" src="<?php echo isset($base_path) ? $base_path : \'\'; ?>assets/images/favicons/icc-logo-derecho.png" alt="ICC-electrica">
                                                    <?php 
                                                }
                                                ?>
                                            </g>
                                        </svg></span>
                                </a>
                            </li>
                        </ul>

                        <ul class="ml-auto nav navbar-nav mr-2 d-none d-lg-flex">
                            <li class="nav-item"><a href="#" class="nav-link"></a></li>
                        </ul>

                        <div class="dropdown">
                            <a href="#account_menu" class="dropdown-toggle navbar-toggler navbar-toggler-dashboard border-left d-flex align-items-center ml-navbar" data-toggle="dropdown">
                                <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBw8HERMTBxARFhMTGBUQFhUSDRsaGRUSGBIXFhgSGBUYKDQmGyYmGxUXITUhJSoyMi4uGx81ODMtNyg5Li0BCgoKDg0NFQ4PGjcZHB0tLSsrNy4vKzctNzcrKystNys3KzcrKystLS0rLSsrKzctKystKystLSsrKysrNysrLf/AABEIAOkA2AMBIgACEQEDEQH/xAAcAAEAAQUBAQAAAAAAAAAAAAAABQIEBgcIAwH/xABBEAACAQIDBQUEBwYEBwAAAAAAAQIDEQQTIQUGEjFRIkFSkZJhcYGhFBUjMjRCsQczcqLB0VNi8PEXVHSClMLS/8QAFwEBAQEBAAAAAAAAAAAAAAAAAAEDAv/EABgRAQEBAQEAAAAAAAAAAAAAAAAREmEB/9oADAMBAAIRAxEAPwDeIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAY/vNvbht3latedVq6pQetusn+Vf6SZ772baWwsNKpGzm+xTT75vvfsSTfw9ppLESniZSniJOU5NylJvVt97An9qftC2jjW/o0o0Y9KcE3b2znf5JENLeHaEnd4zE3/AOol+ly1yxlgTmzt+9pYFrirKpHw1oJ/zK0vmbC3X36w+22qeIWVWeijKV4zfSE+vsfwuahyxl9AOigYn+z7eCW16Lp4x3rUbJt85wf3Zv26WfwfeZYAAAAAAAAAAAAAAAAAAAAAAAAAAAGtv2pYh1K1Gl3Qg6nxnJr9IfMwnLMx/aFFyxmv+HC3uvL+tzGcsC0yxll3ljLAtMsZZd5YywJfcCu8LjqduVRTpP3OPEv5oxNumnt2YNYvD8P+JHyvr8jcIAAAAAAAAAAAAAAAAAAAAAAAAA8cZiI4SnOpU5Qi5u3RK9j2LPbGHeKw9WFPnKEkvfwuy8wNY7a2u9u1eOpTjFxioaSveN21fzZYZZ5YKV6jXVfoyQywLTLGWXeWMsC0yxll3ljLAowGMeyqkKsIqTg3ZN6XcWu733NpbD2ktrUY1Yrhbumr3tJOz1NR7TfBwLq2/L/c2buRQdDB0+P87lU+DenySfxAngAAAAAAAAAAAAAAAAAAAAAAAAABgW8m6U6Vf6Ts3h4O1OpBuzjdO8o9V328vZFZZs+rBVYuMuUk4v3NWNfV8M6EnGotYuzAscsZZd5YywLTLGWXeWMu/ICnZu6lTbNWFTENRw8VZ2l2pvid4pdy5a+RseEFTSUEkkkkktElyRbbKw30OjCD5pXfvbu/my7AAAAAAAAAAAAAAAAAAAAAAAAAAHxu3MD6YZvXio0MVGM7WlTi2+kuKS1+FiS25vbhtmwlkSVSok7KGsVLu4pcufTU1ts7FSxtWbxknKdR8d33y715d3sAy7LGWWeDryw6tNXj817i+WKp9X6WBTll5u66dfEuEtXCLnz04lJK3tte/kReKxTmrUE17e/4dDGtpYqWCqweDk4zp9viT1TfJeXd7QN0gx7YO9mH2lCGfNQqNK6lonLk+GXLn11MhTvyAAAAAAAAAAAAAAAAAAAAAABH7R21htm/i6sVLwrWXpXL4mL70b2vilR2VK3C3GdRPXiXOMeluvl1MNcr6vm9fe+oGZ7Q35lLTZ1JL/NUd36V/cxvH7XxG0PxdWUl4b2j6VoWFxcDzxicoPh7tfgRsW4u8XZrVNdSWuWVfC21peQEvs7b8bKOPT/jiv1j/byJb6ywtr50Pnf08zDKdGU3ZLz7i9+lT4Po3Zy+PN+4uLj4Lfe6ewCQ2jt+NmsAn/HJfpH+5j8pOTvJ3b1bfeyupRlTdmvLvPahhW9avLoBcYJOMFxd+vwJXAbYxGz/AMJVkl4W7x9L0I+4uBmmz9+WrLaNK/8Ampv/ANX/AHMn2dtnD7S/CVIt+F6S9L1NSXEZOLTi7Napp8n1A3UDCd1t7HKUaO1ZXcmowqPm5d0Jdb9fPqZsAAAAAAAAAAAAAACA31219TYZuk7Van2dPqm1rP4L52J81Bv3tX6zxclB9ijelH3p9uXq09yQGP05um7x/wByRhNTV0RhcYSdrr4gXlxcouLgV3Fyi4uBXcfQKvDn8KyuPKvxK/HwXtbnyKLlvf7T/XhAu7i5RcXAruLlFxcCu58lNRV2U3LbFz5Je8DyqVHUd38PYbh3N219dYaMqj+0h9nU9sktJ/Fa++/Q02ZJuFtX6txcY1H2K1qUv4r9iXnp/wBzA26AAAAAAAAAAAAAGF757nLaF6+yklV5zhyVT2rpL9TNABoCcHTbVRNNOzTVmn0afIUnZo3BvLurQ26uL7lZKyqRXP2TX5l80av2xsTEbFnw46Fk3aM46wl7pf0eoFFxcouLgV3Fyi4uBXcXKLi4FdxcouLgV3Fyi4uBXcs6r4my5ue2x9iYjbU7YGF0naU5aQj75f0WoEfCDqNKmm23ZJK7b6JLmbL3M3OWz7V9qpOrzhDmqftfWX6Eru1urQ2EuL79ZqzqSXL2QX5V82T4AAAAAAAAAAAAAAAAA869GGIi414xlF6OMo3TXtTPQAYbtjcKlXvLZc8t+CWsPg+cfmYbtPYGL2Zf6VRlwr88FxR991y+NjcgA0PcXNzY7YOEx/4qhTbf5lHhl6o2ZC4ncDB1f3Mq0PYppr+ZX+YGs7i5nlT9nKf7rFNfxUL/AKSR5f8ADmf/ADUf/Hf/ANAYRcXM8p/s5S/e4pv+Ghb9ZMkMNuBg6X76Vafsc0l/Kr/MDWdyU2ZsDF7Tt9Foy4X+ea4Y++75/C5tLA7BwmA/C0Kaa/M48UvVK7JIDDdj7hUqFpbUnmPwR0h8Xzl8jLqFGGHio0IxjFaKMY2SXsSPQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAeefDxx9SGfDxx9SONMPhPpMlCjGLlLRLRXduV315e89Fs2o4RnCjJwna0o0m1rNwSulo3JWS5vTqd4Sux8+Hjj6kM+Hjj6kceT2LiIcN8NV7SlJJUJNpRlwu6SurO3Pqup7Ud3q9WGY6cIRclTjnTjTc52jK0Izs5aSi9Od1a4wV17nw8cfUhnw8cfUjj/ABGwMVh5ONXCVrqo6F1hpNSqptZcZJWk9Hoiqe72IpcOfR4FKLleceFRtKpHgk2uzK9KfZeugz0rr7Ph44+pDPh44+pHGGXHovIZcei8hgrs/Ph44+pDPh44+pHGGXHovIZcei8hgrs/Ph44+pDPh44+pHGGXHovIZcei8hgrs/Ph44+pDPh44+pHGGXHovIZcei8hgrs/Ph44+pDPh44+pHGGXHovIZcei8hgrs/Ph44+pDPh44+pHGGXHovIZcei8hgrs/Ph44+pDPh44+pHGGXHovI+cEei8hgrtDPh44+pDPh44+pHGGXHovI+cEXyS8hgrtDPh44+pDPh44+pHGHBHovI+cEei8hgrtDPh44+pDPh44+pHF/BHovIOEVzS8hgrtDPh44+pHw4x4IvuXkfBgr1p1JUpKVJ2lFqUX0kndPzRNy3mm3eFKEbO0Ixekab4E6T04mrQWqcdW3rpaCBoiTo7VjRjGEKHZhKM4XrPiUoSlOHFJJcSUqlS6srqS5cNy7we89TButKjD7Ste7daeXrBQ7VBPhm1q4t8m762RAgRWTvfOd5OOGpJzU6U/tJ64edSpUlRVno+KrPtrVK3fduP2ptz6woUcO6MY08PxZNptuEZznOcW396/FDnyy1bm0RAJPAABUAAAAAAAAAAAAAAv9mbVls5SUadKak02qkOK1r3snpr2Xqn92JYACX+vdLfRcJ8aCstIrRdOze3W3xrq7xSrWz8NhpNcOsqbb7PD3t99v06awoEVLPbfFNznhsO21Ba09Oymk0u5tPXq4xfdZ+kN4XCUZQw+Hi42X2UODRWdrrnrGL1vys7pshQIJt7y1ez9lRfDw2bU2+zTnTSbUl3VJd39b1x3oqxjOOVRtOOW32+K2UqV+Li58MVr/uQIEFxtHFvHVZVJqzlbS97WiopXfPRd/wAwW4CP/9k=" class="rounded-circle" width="32" alt="Frontted">
                                <span class="ml-1 d-flex-inline">
                                    <span class="text-light"><?php echo $_SESSION['nombre']; ?></span>
                                </span>
                            </a>
                            <div id="company_menu" class="dropdown-menu dropdown-menu-right navbar-company-menu">
                                <!--<div class="dropdown-item d-flex align-items-center py-2 navbar-company-info py-3">

                                    <span class="mr-3">
                                        <img src="<?php echo isset($base_path) ? $base_path : \'\'; ?>assets/images/frontted-logo-blue.svg" width="43" height="43" alt="avatar">
                                    </span>
                                    <span class="flex d-flex flex-column">
                                        <strong class="h5 m-0">Adrian D.</strong>
                                        <small class="text-muted text-uppercase">STUDENT</small>
                                    </span>

                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item d-flex align-items-center py-2" href="student-edit-account.html">
                                    <span class="material-icons mr-2">account_circle</span> Edit Account
                                </a>
                                <a class="dropdown-item d-flex align-items-center py-2" href="#">
                                    <span class="material-icons mr-2">settings</span> Settings
                                </a>-->
                                <a class="dropdown-item d-flex align-items-center py-2" href="salir.php">
                                    <span class="material-icons mr-2">exit_to_app</span> Cerrar Sesion
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- // END Header -->

        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content">

            <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">