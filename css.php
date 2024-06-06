<!-- Bootstrap CSS v5.2.1 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- google font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet">
<style>
    /* dasgboard 共用 */
    body {
        font-family: "Noto Sans TC", sans-serif;
        font-optical-sizing: auto;
        font-weight: 300;
        font-style: normal;
    }

    a {
        text-decoration: none;
        cursor: pointer;
        user-select: none;
    }

    li>a {
        color: #FFF;
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
        background: linear-gradient(0, #0fd850, #f9f047);
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


    /* 尚謙course */
    .test {
        height: 60px;
    }
</style>