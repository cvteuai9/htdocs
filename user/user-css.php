    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- google-font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patua+One&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
      a {
        text-decoration: none;
      }

      .logo {
        height: 64px;
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

      .table-striped>tbody>tr:nth-child(2n)>td,
      .table-striped>tbody>tr:nth-child(2n)>th {
        background-color: #f5f8ff;
      }


      .table-striped>tbody>tr:nth-of-type(odd)>* {
        --bs-table-bg-type: white;
      }

      .table-header>tr>th {
        background-color: #f5f8ff;
        padding: 15px;
      }

      .table-user>tbody>tr:nth-child(2n+1)>td,
      .table-user>tbody>tr:nth-child(2n+1)>th {
        background-color: #f5f8ff;
      }
    </style>