<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{ 
      $data=array();
             $action = '';
                if(!empty($_REQUEST['action']))
   {
   $action=$_REQUEST['action'];
   }
   if(!empty($_REQUEST['username']))
   {
   $data['username']=$_REQUEST['username'];
   }
   if(!empty($_REQUEST['email']))
   {
   $data['email']=$_REQUEST['email'];
   }
   if(!empty($_REQUEST['password']))
   {
   $data['password']=$_REQUEST['password'];
   }
    if(!empty($_REQUEST['device_id']))
   {
   $data['device_id']=$_REQUEST['device_id'];
   }
    if(!empty($_REQUEST['job_title']))
   {
   $data['job_title']=$_REQUEST['job_title'];
   }
                 if(!empty($_FILES['image']))
   {
   $data['image']=$_FILES['image'];
   }
   if(!empty($_REQUEST['firstname']))
   {
   $data['firstname']=$_REQUEST['firstname'];
   }
                 if(!empty($_REQUEST['facebook_id']))
   {
   $data['facebook_id']=$_REQUEST['facebook_id'];
   }
                 if(!empty($_REQUEST['userdata']))
   {
   $data['userdata']=$_REQUEST['userdata'];
   }
                 if(!empty($_REQUEST['user_id']))
   {
   $data['user_id']=$_REQUEST['user_id'];
   }
                 if(!empty($_REQUEST['access_token']))
   {
   $data['access_token']=$_REQUEST['access_token'];
   }
                 if(!empty($_REQUEST['biodata']))
   {
   $data['biodata']=$_REQUEST['biodata'];
   }
                 if(!empty($_REQUEST['page_no']))
   {
   $data['page_no']=$_REQUEST['page_no'];
   }
                 if(!empty($_REQUEST['search']))
   {
   $data['search']=$_REQUEST['search'];
   }
                 if(!empty($_REQUEST['current_password']))
   {
   $data['current_password']=$_REQUEST['current_password'];
   }
                 if(!empty($_REQUEST['password']))
   {
   $data['password']=$_REQUEST['password'];
   }
                 if(!empty($_REQUEST['game_id']))
   {
   $data['game_id']=$_REQUEST['game_id'];
   }
                 if(!empty($_REQUEST['portfolio_name']))
   {
   $data['portfolio_name']=$_REQUEST['portfolio_name'];
   }
                 if(!empty($_REQUEST['share_id']))
   {
   $data['share_id']=$_REQUEST['share_id'];
   }
                 if(!empty($_REQUEST['portfolio_id']))
   {
   $data['portfolio_id']=$_REQUEST['portfolio_id'];
   }
                 if(!empty($_REQUEST['trade_count']))
   {
   $data['trade_count']=$_REQUEST['trade_count'];
   }
                 if(!empty($_REQUEST['price']))
   {
   $data['price']=$_REQUEST['price'];
   }
                 if(!empty($_REQUEST['status']))
   {
   $data['status']=$_REQUEST['status'];
   }
                 if(!empty($_REQUEST['cash_amount']))
   {
   $data['cash_amount']=$_REQUEST['cash_amount'];
   }
   if(!empty($_REQUEST['total_amount']))
   {
   $data['total_amount']=$_REQUEST['total_amount'];
   }
   if(!empty($_REQUEST['quantity']))
   {
   $data['quantity']=$_REQUEST['quantity'];
   }   
   if(!empty($_REQUEST['subject']))
   {
   $data['subject']=$_REQUEST['subject'];
   }  
   if(!empty($_REQUEST['comments']))
   {
   $data['comments']=$_REQUEST['comments'];
   }  
   if(!empty($_REQUEST['queries']))
   {
   $data['queries']=$_REQUEST['queries'];
   }  
                 
  // print_r($postfield  =json_encode($data));exit;
                 $postfields  ='params='.json_encode($data);
   
$url = "http://hercules.softwaytechnologies.com/stox_web/trunk/web_services/apis?action=".$action."&amp;params=".json_encode($data);

//$postfield = 'params={ "username": "abctest",     "job_title": "developer",     "device_id": "123",     "email": "abctest@test.com",     "password": "123456" }';
print_r($postfields);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_REFERER, $url);
curl_setopt($ch, CURLOPT_VERBOSE, 1);





curl_setopt($ch, CURLOPT_POSTFIELDS, ($postfields));
$curl_response = curl_exec($ch); // Get result after login page.

print_r($curl_response);


}





?>

<html>
<head>
 


 <link rel="stylesheet" type="text/css" href="http://www.drivertrainingassociates.com/css/style.css" />
 </head>

 </head>
 <body>
     
     <p></p> <h3>---------------------------1. Registration--------------------------------</h3>    
<form name="registration"  method="POST" enctype="multipart/form-data">
 Action: <input type="text" value="register" name="action"><br/>
Username: <input type="text" name="username"><br/>
Job: <input type="text" name="job_title"><br/>
Device: <input type="text" name="device_id"><br/>
Email: <input type="text" name="email"><br/>
Password: <input type="text" name="password"><br/>
Image: <input type="file" name ="image"><br/>
<input type="submit" value="Submit">
</form> 

<p><h3>---------------------------2. Login--------------------------------</h3></p>  
<form name="login"  method="POST">
Service Name:   <input type="text" name="action" value="login" readonly="true"><br/>
Username/Email: <input type="text" name="username"><br/>
Password: <input type="text" name="password"><br/>
<input type="submit" value="Submit">
</form> 
            
<p><h3>---------------------------3. Facebook Login--------------------------------</h3></p>  
<form name="social_login"  method="POST">
Service Name:   <input type="text" name="action" value="social_login" readonly="true"><br/>
Firstname: <input type="text" name="firstname"><br/>
Email: <input type="text" name="email"><br/>
Facebook Id: <input type="text" name="facebook_id"><br/>
Device_id: <input type="text" name="device_id"><br/>
<input type="submit" value="Submit">
</form> 
                       
<p><h3>---------------------------4. Forgot Password--------------------------------</h3></p>  
<form name="forgot_password"  method="POST">
Service Name:   <input type="text" name="action" value="forgot_password" readonly="true"><br/>
userdata: <input type="text" name="userdata"><br/>
<input type="submit" value="Submit">
</form>    
            

<p><h3>---------------------------5. Logout--------------------------------</h3></p>              
<form name="logout"  method="POST">
Service Name:   <input type="text" name="action" value="logout" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
<input type="submit" value="Submit">
</form>  
            
<p><h3>---------------------------6. Edit Bio Data--------------------------------</h3></p>                 
<form name="bio"  method="POST">
Service Name:   <input type="text" name="action" value="bio" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
biodata: <input type="text" name="biodata"><br/>
<input type="submit" value="Submit">
</form>
            
<p><h3>---------------------------7. List of Games--------------------------------</h3></p>                 
<form name="game_list"  method="POST">
Service Name:   <input type="text" name="action" value="game_list" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
<input type="submit" value="Submit">
</form>
            
<p><h3>---------------------------8. Stock Datas--------------------------------</h3></p>             
<form name="get_share_data"  method="POST">
Service Name:   <input type="text" name="action" value="get_share_data" readonly="true"><br/>
page_no: <input type="text" name="page_no"><br/>
search: <input type="text" name="search"><br/>
<input type="submit" value="Submit">
</form>
            
            
<p><h3>---------------------------9. Change Password--------------------------------</h3></p> 
<form name="change_password"  method="POST">
Service Name:   <input type="text" name="action" value="change_password" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
current_password: <input type="text" name="current_password"><br/>
password: <input type="text" name="password"><br/>
<input type="submit" value="Submit">
</form>
            
<p><h3>---------------------------10. Create Portfolio--------------------------------</h3></p>             
<form name="portfolio"  method="POST">
Service Name:   <input type="text" name="action" value="portfolio" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
game_id: <input type="text" name="game_id"><br/>
portfolio_name: <input type="text" name="portfolio_name"><br/>
<input type="submit" value="Submit">
</form>
            
            
<p><h3>---------------------------11. Show net amount--------------------------------</h3></p> 
<form name="show_portfolio_net_value"  method="POST">
Service Name:   <input type="text" name="action" value="show_portfolio_net_value" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
game_id: <input type="text" name="game_id"><br/>
<input type="submit" value="Submit">
</form> 

<p><h3>---------------------------12. Show the summation of the net value of all the portfolios --------------------------------</h3></p> 
<form name="total_portfolio_net_value"  method="POST">
Service Name:   <input type="text" name="action" value="total_portfolio_net_value" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
<input type="submit" value="Submit">
</form> 
            
<p><h3>---------------------------13. Show List of Portfolios--------------------------------</h3></p>             
<form name="show_portfolio_list"  method="POST">
Service Name:   <input type="text" name="action" value="show_portfolio_list" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
game_id: <input type="text" name="game_id"><br/>
<input type="submit" value="Submit">
</form> 
            
            
<p><h3>---------------------------14. Add shares to the Watchlist--------------------------------</h3></p>             
            
<form name="add_watchlist"  method="POST">
Service Name:   <input type="text" name="action" value="add_watchlist" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
share_id: <input type="text" name="share_id"><br/>
portfolio_id: <input type="text" name="portfolio_id"><br/>
<input type="submit" value="Submit">
</form> 
            
<p><h3>---------------------------15. Show bankdata--------------------------------</h3></p>
<form name="show_bankdata"  method="POST">
Service Name:   <input type="text" name="action" value="show_bankdata" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
<input type="submit" value="Submit">
</form> 
            
            
<p><h3>---------------------------17. Buy Trades--------------------------------</h3></p>            
<form name="buy_trades"  method="POST">
Service Name:   <input type="text" name="action" value="buy_trades" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
portfolio_id: <input type="text" name="portfolio_id"><br/>
trade_count: <input type="text" name="trade_count"><br/>
price: <input type="text" name="price"><br/>
status: <input type="text" name="status"><br/>
<input type="submit" value="Submit">
</form> 
            
<p><h3>---------------------------18. Buy Cash--------------------------------</h3></p>              
<form name="buy_cash"  method="POST">
Service Name:   <input type="text" name="action" value="buy_cash" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
portfolio_id: <input type="text" name="portfolio_id"><br/>
cash_amount: <input type="text" name="cash_amount"><br/>
price: <input type="text" name="price"><br/>
status: <input type="text" name="status"><br/>
<input type="submit" value="Submit">
</form>   
            
<p><h3>---------------------------19. Edit only the image--------------------------------</h3></p>                
<form name="upload_image"  method="POST" enctype="multipart/form-data">
Service Name:   <input type="text" name="action" value="upload_image" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
Image: <input type="file" name ="image"><br/>
<input type="submit" value="Submit">
</form>   
     
<p><h3>---------------------------20. Show watchlist--------------------------------</h3></p>                     
<form name="show_watchlist"  method="POST">
Service Name:   <input type="text" name="action" value="show_watchlist" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
portfolio_id: <input type="text" name="portfolio_id"><br/>
<input type="submit" value="Submit">
</form>   
     
<p><h3>---------------------------21. Guest Registration--------------------------------</h3></p>                     
<form name="check_guest"  method="POST">
Service Name:   <input type="text" name="action" value="check_guest" readonly="true"><br/>
device_id: <input type="text" name="device_id"><br/>
<input type="submit" value="Submit">
</form>   
     
 <p><h3>---------------------------21. List of Purchased stocks--------------------------------</h3></p>                         
<form name="purchased_stocks"  method="POST">
Service Name:   <input type="text" name="action" value="purchased_stocks" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
portfolio_id: <input type="text" name="portfolio_id"><br/>
<input type="submit" value="Submit">
</form> 
     
     
 <p><h3>---------------------------21. Stock History--------------------------------</h3></p>                              
<form name="stock_history"  method="POST">
Service Name:   <input type="text" name="action" value="stock_history" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
portfolio_id: <input type="text" name="portfolio_id"><br/>
<input type="submit" value="Submit">
</form> 
     
<p><h3>---------------------------22. List of Pending stocks--------------------------------</h3></p>         
<form name="pending_stocks"  method="POST">
Service Name:   <input type="text" name="action" value="pending_stocks" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
portfolio_id: <input type="text" name="portfolio_id"><br/>
<input type="submit" value="Submit">
</form> 


<p><h3>---------------------------23. Buying stocks--------------------------------</h3></p>         
<form name="buying_stocks"  method="POST">
Service Name:   <input type="text" name="action" value="buying_stocks" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
portfolio_id: <input type="text" name="portfolio_id"><br/>
game_id: <input type="text" name="game_id"><br/>
total_amount: <input type="text" name="total_amount"><br/>
share_id: <input type="text" name="share_id"><br/>
quantity: <input type="text" name="quantity"><br/>
<input type="submit" value="Submit">
</form> 


<p><h3>---------------------------24. Premium Game list--------------------------------</h3></p>
<form name="premium_games"  method="POST">
Service Name:   <input type="text" name="action" value="premium_games" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
<input type="submit" value="Submit">
</form> 


<p><h3>---------------------------25. FAQ data--------------------------------</h3></p>
<form name="faq_data"  method="POST">
Service Name:   <input type="text" name="action" value="faq_data" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
<input type="submit" value="Submit">
</form> 

<p><h3>---------------------------26. Feedback form--------------------------------</h3></p>
<form name="feedback_data"  method="POST">
Service Name:   <input type="text" name="action" value="feedback_data" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
subject: <input type="text" name="subject"><br/>
comments: <input type="text" name="comments"><br/>
<input type="submit" value="Submit">
</form> 

<p><h3>---------------------------27. Contact Us form--------------------------------</h3></p>
<form name="contactus_data"  method="POST">
Service Name:   <input type="text" name="action" value="contactus_data" readonly="true"><br/>
user_id: <input type="text" name="user_id"><br/>
access_token: <input type="text" name="access_token"><br/>
subject: <input type="text" name="subject"><br/>
queries: <input type="text" name="queries"><br/>
<input type="submit" value="Submit">
</form> 

