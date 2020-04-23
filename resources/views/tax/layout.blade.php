<style>
    @import url('https://fonts.googleapis.com/css?family=Mukta&display=swap');
    ​
    body {
        width: 100% !important;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Mukta';
        background-color: #fff;
    }
    #background_table {
        margin: auto;
        padding: 0;
        width: 100%!important;
        line-height: 100%!important;
    }
    ​
    table td {
        border-collapse: collapse;
        vertical-align:middle;
        font-size: 14px;
        color: #000;
        text-align: center;
    }
    table td[class="column"] {
        height:100px;
        width:200px;
    }
    table {
        border-collapse: collapse;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
    }
    ​
    table[class="body_table"] {
        width: 600px;
    }
    ​
    @media only screen and (max-width: 480px) {
        table[class="body_table"] {
            width: 300px!important;
        }
        ​
        table td[class="text"] {
            padding-left: 0!important;
            padding-right: 0!important;
        }
        table td[class="table_image"] {
            padding-left: 0!important;
            padding-right: 0!important;
            height: 200px !important;
        }
        ​
        table td[class="header_title"] {
            height: 60px !important;
        }
        ​
        table td[class="border"] {
            height: 30px !important;
        }
        ​
        table td[class="mobile"] {
            display: none !important;
        }
        table td[class="column"] {
            width:100%!important;
            display: block!important;
        }
    }
</style>
<table width="100%" cellpadding="0" cellspacing="0" border="0" id="background_table">
    <tbody>
    <tr>
        <td>​
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="body_table">
                <tbody>

                    <tr>
                        <td>
                            @yield('content')
                        </td>
                    </tr>
                ​
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
