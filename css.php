<!-- Bootstrap CSS v5.2.1 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- google font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=LXGW+WenKai+TC&display=swap" rel="stylesheet">
<style>
    /* dasgboard 共用 */
    a {
        text-decoration: none;
        cursor: pointer;
        user-select: none;
    }

    li>a {
        color: #198754;
    }

    :root {
        --aside-witch: 200px;
        --header-height: 50px;
    }

    .logo {
        width: var(--aside-witch);
    }

    .aside-left {
        /* background: #F5F5DC; */
        padding-top: var(--header-height);
        width: var(--aside-witch);
        top: 20px;
        overflow: auto;
    }

    .deactive {
        height: 0px;
        overflow: hidden;
    }

    ul {
        transition: .5s;
    }

    .list-active {
        height: 90px;
        overflow: hidden;
    }

    .main-content {
        margin: var(--header-height) 0 0 var(--aside-witch);
    }

    .google-font {
        font-family: "LXGW WenKai TC", cursive;
        font-weight: 400;
        font-style: normal;
    }

    /* 尚謙course */
    .test {
        height: 60px;
    }

    /* julia users */
    body {
        font-weight: bold;
    }

    .cart-icon {
        font-size: 36px;
        text-decoration: none;
        color: #000;

        span {
            background: #D33F33;
            top: -4px;
            right: -8px;
            display: flex;
            font-size: 14px;
            justify-content: center;
            align-items: center;
            color: #fff;
            height: 24px;
            width: 24px;
            border-radius: 50%;
        }
    }

    .favorite-icon {
        background: #31283B;
        font-size: 1rem;
        right: 10px;
        bottom: 10px;
        width: 2rem;
        height: 2rem;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        box-shadow: #D33F33 3px 3px;
        color: #F1DAD4;

        &.active {
            color: #D33F33;
        }
    }
</style>