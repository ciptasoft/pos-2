<?php

class ExportToExcel
{  
function exportWithPage($php_page,$excel_file_name)  
{  
$this->setHeader($excel_file_name);   require_once "$php_page";   
}    

function setHeader($excel_file_name)  
{   
		header("Content-Type:   application/vnd.ms-excel; charset=ISO-8859-6");
		
		header( "Content-Type: text/html; charset=ISO-8859-6" );
		header('Content-Type:text/html; charset=UTF-8');
		header('Content-Disposition: attachment; filename="export'.date("Y_m_d:H_m_s").'".xls"');
		header('Cache-Control: max-age=0');   
}    

function exportWithQuery($qry1,$qry2,$qry3,$qry4,$excel_file_name,$conn)  
{  
$body="<center><table border=1px>";
$tmprst1=mysql_query($qry1,$conn);  
$tmprst2=mysql_query($qry2,$conn);  
$tmprst3=mysql_query($qry3,$conn);
$tmprst4=mysql_query($qry4,$conn);
$body.="<tr>"; 
		for ($i = 0; $i < mysql_num_fields($tmprst1); $i++) 
		{ 
			
			$body.="<th>".mysql_field_name($tmprst1,$i)."</th>"; 
		} 
$body.="<th>TYPE</th>";
$body.="</tr>"; 
$header=$header11;  
$num_field=mysql_num_fields($tmprst1);  


while($row=mysql_fetch_array($tmprst1,MYSQL_BOTH))  
{    $body.="<tr>";   
for($i=0;$i<$num_field;$i++)   
{     $body.="<td>".$row[$i]."</td>";    } 
$body.="<td>Sales</td>";
$body.="</tr>";   
}  

while($row=mysql_fetch_array($tmprst2,MYSQL_BOTH))  
{    $body.="<tr>";   
for($i=0;$i<$num_field;$i++)   
{     $body.="<td>".$row[$i]."</td>";    } 
$body.="<td>Sales Return</td>";
$body.="</tr>";   
}

while($row=mysql_fetch_array($tmprst3,MYSQL_BOTH))  
{    $body.="<tr>";   
for($i=0;$i<$num_field;$i++)   
{     $body.="<td>".$row[$i]."</td>";    } 
$body.="<td>Purchase</td>";
$body.="</tr>";   
}  

while($row=mysql_fetch_array($tmprst4,MYSQL_BOTH))  
{    $body.="<tr>";   
for($i=0;$i<$num_field;$i++)   
{     $body.="<td>".$row[$i]."</td>";    } 
$body.="<td>Purchase Return</td>";
$body.="</tr>";   
}

$this->setHeader($excel_file_name);  
echo $header.$body."</table>";  
}
} 
?>
