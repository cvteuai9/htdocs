<style>
    /* ---------------新增樣式-------------- */
    /* 按鈕 */
    .btn-custom {
        background-color: #A98B73;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 14px;
    }

    .btn-custom:hover {
        background-color: #876d5a;
    }

    .btn-custom-d {
        background-color: #800000;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 14px;
    }

    /* 狀態 */
    .status-custom {
        color: whitesmoke;
        border: none;
        padding: 10px 10px;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        margin: 4px 2px;
        border-radius: 14px;
        font-weight: bold;
    }

    #status-available {
        background-color: #4CAF50;
    }

    #status-not-open {
        background-color: #bbb;
    }

    #status-disabled {
        background-color: #800000;
    }

    /* sort排序 */
    .sort-icon {
        color: #A98B73;
        margin-left: 5px;
    }

    /* 查看詳細資訊 */
    .eye-icon {
        color: #A98B73;
    }

    /* 頁籤 */
    .pagination .active .page-link {
        background-color: #A98B73;
        color: white;
        border-color: #A98B73;
    }
    /* .pagination {
        --bs-pagination-font-size:20px
    } */


    .pagination .page-link {
        color: #A98B73;
        font-size: 20px;
        /* --bs-pagination-font-size:30px */
        
    }

    /* 表格顏色 */

    .table-striped>tbody>tr:nth-child(2n)>td,
    .table-striped>tbody>tr:nth-child(2n)>th {
        background-color: #eee0c9 ;
    }

    
    .table-striped>tbody>tr:nth-of-type(odd)>* {
        --bs-table-bg-type: #fbf7f1;
    }

    .table-header>tr>th {
        background-color: #DABEA7;
        padding: 15px;
    }

    .table-coupon>tbody>tr>th {
        background-color: rgb(236, 220, 194);
    }

    .table>:not(caption)>*>* {
        padding: 15px;
    }

    .table-coupon{
        td{

            border-width: 1.5px;
        }

        tr{

            border-color: #DABEA7;
            border-style: solid;
            border-width: 1px;
        }
    }

    /* 編輯優惠券類別 */
    /* 更改选中状态的单选按钮颜色 */
    .form-check-input:checked {
        background-color: #876d5a;
        border-color: #876d5a;
    }

    /* 更改选中状态的单选按钮旁边的标签颜色 */
    .form-check-input:checked+.form-check-label {
        color: #876d5a;
    }
</style>