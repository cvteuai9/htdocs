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
        color: white;
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
    background-color:#198754;
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
    /* 頁籤顏色 */
    .pagination .active .page-link {
        background-color: #198754;
        color: white;
        border-color: #198754;
    }
    .pagination .page-link {
        color: #198754;
        font-size: 20px;
        /* --bs-pagination-font-size:30px */

    }
    
    
    /* 尚謙course */
    .test {
        height: 60px;
    }
    /* logo */
    .logo-img{
        width: auto;
        height: 50px;
    }
    

</style>