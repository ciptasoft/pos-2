<html>
<head>
<title>Welcome to POS API</title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

</style>
</head>
<body>

<h1>Welcome to POS REST API!</h1>


<p></p>

<p style="border:1px solid #069;">
&nbsp;&nbsp;&nbsp;<a href="<?php echo Yii::app()->params->base_path; ?>api/showLogs/"><strong>ShowLogs</strong></a> &nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;<a href="<?php echo Yii::app()->params->base_path; ?>api/clearLogs/"><strong>ClearLogs</strong></a>
</p>
<p></p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/login&loginId=vpanchal911@gmail.com&password=111111"><strong>login</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/login&loginId=vpanchal911@gmail.com&password=111111</p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : loginId , password </p>
<p>--------------------------------------------------------------------------------------------------</p>

<p><a href="<?php echo Yii::app()->params->base_path; ?>api/insertShiftDetails&cashier_id=164&cash_in=10000&sessionId=XMcVHSqnno"><strong>insertShiftDetails</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/insertShiftDetails&cashier_id=164&cash=10000&sessionId=XMcVHSqnno </p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : cashier_id , cash , sessionId ,shift_id</p>
<p><strong>Note</strong> : If It is use for LogOut then at that time insert <b>"shift_id"</b> in parameter.</p>

<p>--------------------------------------------------------------------------------------------------</p>

<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getProductByUpcCode&upc_code=111111&userId=165&sessionId=Ws3hudfyzn&admin_id=3"><strong>getProductByUpcCode</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getProductByUpcCode&upc_code=111111&userId=165&sessionId=Ws3hudfyzn&admin_id=3</p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : upc_code , userId , sessionId , admin_id </p>

<p>--------------------------------------------------------------------------------------------------</p>

<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getPendingTickets&userId=165&sessionId=XMcVHSqnno"><strong>getPendingTickets</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getPendingTickets&userId=165&sessionId=XMcVHSqnno </p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId </p>
<p>--------------------------------------------------------------------------------------------------</p>

<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getCustomerList&userId=165&sessionId=XMcVHSqnno"><strong>getCustomerList</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getCustomerList&userId=165&sessionId=XMcVHSqnno </p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId </p>
<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getProductList&userId=165&sessionId=n6F2w1CtMD&admin_id=3"><strong>getProductList</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getProductList&userId=165&sessionId=n6F2w1CtMD&admin_id=3 </p>
<p><strong>Params</strong></p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId ,admin_id </p>
--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getCategoryList&userId=165&sessionId=e7zZFVgz47&admin_id=3"><strong>getCategoryList</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getCategoryList&userId=165&sessionId=e7zZFVgz47&admin_id=3 </p>
<p><strong>Params</strong></p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId ,admin_id </p>
--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getProductListByCategoryId&userId=165&sessionId=e7zZFVgz47&admin_id=3&cat_id=15"><strong>getProductListByCategoryId</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getProductListByCategoryId&userId=165&sessionId=e7zZFVgz47&admin_id=3&cat_id=15</p>
<p><strong>Params</strong></p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId ,admin_id , cat_id </p>
<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getStoreList&userId=165&sessionId=n6F2w1CtMD&admin_id=3"><strong>getStoreList</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getStoreList&userId=165&sessionId=n6F2w1CtMD&admin_id=3</p>
<p><strong>Params</strong></p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId , admin_id </p>
<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getStockList&userId=165&sessionId=hu7TJdFFWu&admin_id=3"><strong>getStockList</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getStockList&userId=165&sessionId=hu7TJdFFWu&admin_id=3</p>
<p><strong>Params</strong></p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId , admin_id </p>
<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getProductStockList&userId=165&sessionId=IzLRFdIT14&admin_id=3&product_id=34"><strong></strong></a><a href="<?php echo Yii::app()->params->base_path; ?>api/getProductStockList&userId=165&sessionId=IzLRFdIT14&admin_id=3&product_id=34"><strong>getProductStockList</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getProductStockList&userId=165&sessionId=IzLRFdIT14&admin_id=3&product_id=34</p>
<p><strong>Params</strong></p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId , admin_id , product_id</p>
<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getDailyReturnTotalSalesCount&userId=165&sessionId=XMcVHSqnno"><strong></strong></a><a href="<?php echo Yii::app()->params->base_path; ?>api/getDailyReturnTotalSalesCount&userId=165&sessionId=XMcVHSqnno"><strong></strong></a><a href="<?php echo Yii::app()->params->base_path; ?>api/getDailyReturnTotalSalesCount&userId=165&sessionId=XMcVHSqnno"><strong>getDailyReturnTotalSalesCount</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getDailyReturnTotalSalesCount&userId=165&sessionId=XMcVHSqnno </p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId </p>
<p>--------------------------------------------------------------------------------------------------</p>

<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getDailyPendingTotalSalesCount&userId=165&sessionId=XMcVHSqnno"><strong>getDailyPendingTotalSalesCount</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getDailyPendingTotalSalesCount&userId=165&sessionId=XMcVHSqnno </p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId </p>

<p>--------------------------------------------------------------------------------------------------</p>

<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getDailyTotalSalesCount&userId=165&sessionId=XMcVHSqnno"><strong>getDailyTotalSalesCount</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getDailyTotalSalesCount&userId=165&sessionId=XMcVHSqnno </p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId </p>

<p>--------------------------------------------------------------------------------------------------</p>

<p><a href="<?php echo Yii::app()->params->base_path; ?>api/exitShiftDetails&cashier_id=164&cash_out=10000&shift_id=14&sessionId=XMcVHSqnno"><strong>exitShiftDetails</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/exitShiftDetails&cashier_id=164&cash_out=10000&shift_id=14&sessionId=XMcVHSqnno </p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : cashier_id , cash_out , shift_id , sessionId </p>

<p>--------------------------------------------------------------------------------------------------</p>

<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getTicketList&userId=165&sessionId=XMcVHSqnno"><strong>getTicketList</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getTicketList&userId=165&sessionId=XMcVHSqnno </p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId </p>


<p>--------------------------------------------------------------------------------------------------</p>

<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getReturnTickets&userId=165&sessionId=XMcVHSqnno"><strong>getReturnTickets</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getReturnTickets&userId=165&sessionId=XMcVHSqnno </p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId </p>

<p>--------------------------------------------------------------------------------------------------</p>

<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getReceiveMessageList&userId=165&sessionId=XMcVHSqnno"><strong>getReceiveMessageList</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getReceiveMessageList&userId=165&sessionId=XMcVHSqnno </p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId </p>

<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/insertVaultDetails&cashier_id=165&shift_id=175&withdraw=10000&deposite=5000&sessionId=XMcVHSqnno"><strong>insertVaultDetails</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/insertVaultDetails&cashier_id=164&shift_id=175&withdraw=10000&deposite=5000&sessionId=XMcVHSqnno </p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : cashier_id , shift_id , withdraw , deposite , sessionId </p>

<p>--------------------------------------------------------------------------------------------------</p>


<p><a href="<?php echo Yii::app()->params->base_path; ?>api/submitTicket&customer_id=1&discountType=0&discount=10&total_quantity=1&total_product=2&userId=165&sessionId=EyBI97XmkO&total_item=1&total_amount=100&cashPayment=1111&cardPayment=0&bankPayment=0&creditPayment=0&paymentType=1&status=1&quantity1=1&rate1=1&product1=7&amount1=12343&store_id1=1&quantity2=1&rate2=1&product2=7&amount2=12343&store_id2=3"><strong>submitTicket</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/submitTicket&cashier_id=164&shift_id=175&withdraw=10000&deposite=5000&sessionId=XMcVHSqnno </p>
<p><strong>Params</strong> </p>
<p><strong>Method</strong> :POST</p>
<p><strong>Fields</strong> :&customer_id=1&discount=10&total_quantity=1&total_product=2&userId=165&sessionId=EyBI97XmkO&total_item=1&total_amount=100&cashPayment=1111&cardPayment=0&bankPayment=0&creditPayment=0&discountType=0&paymentType=1&status=1&quantity1=1&rate1=1&product1=7&amount1=12343&store_id1=1&quantity2=1&rate2=1&product2=7&amount2=12343&store_id2=3 </p>
<strong>NOTE:</strong> Add Store Id with every product. DiscountType: 0 means Percentage and 1 means Flat discount.

<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/changePassword&oldpassword=222222&newpassword=111111&confirmpassword=111111&userId=175&sessionId=sdfsdf"><strong>changePassword</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/changePassword&oldpassword=222222&newpassword=111111&confirmpassword=111111&userId=175&sessionId=sdfsdf</p>
<p><strong>Params</strong> oldpassword , newpassword , confirmpassword , userId , sessionId</p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> :&oldpassword=222222&newpassword=111111&confirmpassword=111111&userId=175&sessionId=sdfsdf</p>
<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/aboutme&firstName=Vishal&lastName=Panchal&loginId=dj@gmail.com&userId=175&sessionId=sdfkjsf"><strong>aboutme</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/aboutme&firstName=Vishal&lastName=Panchal&loginId=dj@gmail.com&userId=175&sessionId=sdfkjsf</p>
<p><strong>Params</strong> firstName  , lastName , loginId  , userId , sessionId</p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> :&firstName=Vishal&lastName=Panchal&loginId=dj@gmail.com&userId=175&sessionId=sdfkjsf</p>
<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getQueryLog&log_id=7&userId=165&sessionId=SdscSEs"><strong>getQueryLog</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getQueryLog&log_id=7&userId=165&sessionId=SdscSEs</p>
<p><strong>Params</strong> log_id </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> :&log_id=7&userId=165&sessionId=SdscSEs </p>
<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getQueryLogCount&log_id=7&userId=165&sessionId=SdscSEs"><strong>getQueryLogCount</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getQueryLogCount&log_id=7&userId=165&sessionId=SdscSEs</p>
<p><strong>Params</strong> log_id </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> :&log_id=7&userId=165&sessionId=SdscSEs </p>
<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getTicketDetailsForSalesReturn&userId=165&sessionId=0XKuoQI3HZ&invoiceId=165201380"><strong>getTicketDetailsForSalesReturn</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getTicketDetailsForSalesReturn&userId=165&sessionId=0XKuoQI3HZ&invoiceId=165201380</p>
<p><strong>Params</strong> userId , sessionId , invoiceId </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> :&userId=165&sessionId=0XKuoQI3HZ&invoiceId=165201380 </p>
<p>--------------------------------------------------------------------------------------------------</p>


<p><a href="<?php echo Yii::app()->params->base_path; ?>api/submitSalesReturnTicket&userId=165&sessionId=EyBI97XmkO&invoiceId=1&return_customer_id=1&return_discountType=0&return_discount=10&return_total_quantity=1&total_return_product=2&return_total_item=1&return_total_amount=100&return_quantity1=1&return_price1=1&return_product_id1=7&return_product_total1=12343&return_store_id1=1&return_quantity2=1&return_price2=1&return_product_id2=7&return_product_total2=12343&return_store_id2=1"><strong>submitSalesReturnTicket</strong></a> : 
<p><strong>Params</strong> </p>
<p><strong>Method</strong> :POST</p>
<p><strong>Fields</strong> :&userId=165&sessionId=EyBI97XmkO&invoiceId=1&return_customer_id=1&return_discountType=0&return_discount=10&return_total_quantity=1&total_return_product=2&return_total_item=1&return_total_amount=100&return_quantity1=1&return_price1=1&return_product_id1=7&return_product_total1=12343&return_store_id1=1&return_quantity2=1&return_price2=1&return_product_id2=7&return_product_total2=12343&return_store_id2=1 </p>
<strong>NOTE:</strong> Add Store Id with every product. DiscountType: 0 means Percentage and 1 means Flat discount.

<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getTotalAmountReport&userId=165&sessionId=AKrS0tBKkV&date1=2012-01-25&date2=2013-01-25"><strong>getTotalAmountReport</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getTotalAmountReport&userId=165&sessionId=AKrS0tBKkV&date1=2012-01-25&date2=2013-01-25</p>
<p><strong>Params</strong> userId , sessionId , date1 , date2 </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> :&userId=165&sessionId=AKrS0tBKkV&date1=2012-01-25&date2=2013-01-25 </p>
<p><strong>Note : </strong> date formate :: "YYYY-MM-DD" , date1 < date2</p>
<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getProductReport&userId=165&sessionId=AZg1UCKCFz&date1=2012-01-25&date2=2013-01-25"><strong>getProductReport</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getProductReport&userId=165&sessionId=AZg1UCKCFz&date1=2012-01-25&date2=2013-01-25</p>
<p><strong>Params</strong> userId , sessionId , date1 , date2 ,product_id</p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> :&userId=165&sessionId=AKrS0tBKkV&date1=2012-01-25&date2=2013-01-25 </p>
<p><strong>Note : </strong> date formate :: "YYYY-MM-DD" , date1 < date2</p>
<p><strong>Note : </strong> If you want to get report of perticular one product than please add "product_id" parameter.</p>
<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/getProductTotalForReport&userId=165&sessionId=PGKtcQzgOT&date1=2012-01-25&date2=2013-01-25"><strong>getProductTotalForReport</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/getProductTotalForReport&userId=165&sessionId=PGKtcQzgOT&date1=2012-01-25&date2=2013-01-25</p>
<p><strong>Params</strong> userId , sessionId ,date1 ,date2  </p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> :&userId=165&sessionId=AKrS0tBKkV&date1=2012-01-25&date2=2013-01-25</p>
<p><strong>Note : </strong> date formate :: "YYYY-MM-DD" , date1 < date2</p>

<p>--------------------------------------------------------------------------------------------------</p>
<p><a href="<?php echo Yii::app()->params->base_path; ?>api/logout&userId=165&sessionId=SdscSEs"><strong>logout</strong></a> : <?php echo Yii::app()->params->base_path; ?>api/logout&userId=165&sessionId=SdscSEs</p>
<p><strong>Params</strong></p>
<p><strong>Method</strong> : GET and POST</p>
<p><strong>Fields</strong> : userId , sessionId </p>
<p>--------------------------------------------------------------------------------------------------</p>

</body>
</html>