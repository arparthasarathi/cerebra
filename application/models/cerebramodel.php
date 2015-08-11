<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Cerebramodel extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    {
      $this->load->database();
      $this->load->helper('url');
      $this->load->helper('date');

    }
  }
function initialize($kid){
    $q="SELECT kid from k13_cerebra where kid=?";
    $res=$this->db->query($q,$kid);
    if($res->num_rows()>0)
      return;
    else
    {//set initial value in database.
      $query1="Select fullname from bitauth_userdata where kid=?";
      $result1=$this->db->query($query1,$kid);
      foreach($result1->result() as $row1)
        $name=trim($row1->fullname);    
//////////////////////////////////////////////////////
      $qid=array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40);
      
      for($value=1;$value<count($qid);$value++) 
      {
      $this->db->insert('k13_cerebra',array('kid'=>$kid,'qid'=>$qid[$value],'attempt'=>0,'flag'=>0));
      }

    $this->db->insert('cerebra_users',array('kid'=>$kid,'name'=>$name,'points'=>0,'answered'=>0));  

      
      //fb post..
    }
  }

public function getques($kid)
{
  $q1="select points,answered from cerebra_users where kid=?";
  $r1= $this->db->query($q1,$kid);
  $rr1   = $r1->row();
  
  
    $q2    = "select qid,attempt,flag from k13_cerebra where kid=?";
    $r2    = $this->db->query($q2,$kid);
    $rr2   = $r2->row();
    $qid=array();
    $qa=array();
    $qw=array();
    $i=1;
    foreach($r2->result() as $row)
      $qid[$i++]=$row->qid;

  $i=1;
    //$qa    = $rr2->flag;
    //$qw    = $rr2->attempt;
    foreach($r2->result() as $row)
      {
        $qa[$i]=$row->flag;
        $qw[$i] = $row->attempt;
        $i++;
      }
        


$ques= array("cerebraset2",

"A geek kid goes to shop for purchasing chocolates. There was an offer stating,'Get 1 chocolate for 3 chocolate wrappers'. If the cost of the each chocolate is Re.1 and the kid has Rs.95 in hand, find the maximum number of chocolates he can buy?",


"If M is the centre of the circle and x=2y, What is the probability that, any point chosen on the circumference of the circle will lie on the arc ABC? <br>(FORMAT: 0.xx Round off to two decimals)<br>
<img src='http://kurukshetra.org.in/cerebra/assets/images/1.png'></img>

<br>",

"There are 8 people who are participating in rowing races in teams. 3 matches in a row drew, with the following line ups:<br>
1. 1234 vs 5678<br>
2. 283 vs 71<br>
3. 41 vs 865<br>
The next match is 56 vs?<br>
If this match is to also be a draw, which person(s) should row against 56? Give your answer in ascending order.",


"Decrypt<br>
rnmfqctukcthnm",



"Consider the domain of whole numbers where every number is taken and the number is continuously reduced to a non-trivial factor of the number until 0 was reached. Write down the set of numbers in the increasing order that depicts the number of minimum steps it will take to reduce.<br>
For e.g.: if the minimum steps that can possible be are{ 5,16,19,20,0) then write your answer as:<br>
05161920",



"Continue the series(next term): <br>
2034, 2036, 2040, 2042, 2044, …?",



"Samuel, the old man, stated in the year 1937 that, he was y years old in the year y2.Samuel then added, 'if the number of my years(i.e his age in x2) be added to the number of my month(from birthday), it would result in the square of the day of the month(from birthday), on which I was born'. Find his birthdate (Format: DDMMYYYY)",


"If <br>
12=6 <br>
6=3<br>
3=5<br>
5=4<br>
4=?<br>
",

"You need to find a 4 digit code of distinct digits from 0-5. You get feedback on how close you are to the correct code with each try, in the form of m’s and n’s; A m means that a number in your guess is present in the correct code, but in a different position, and a n means that a number in your code is in the same place as it should be in the correct code. Here are your first 4 trials: <br>
3124 : mm<br>
0512: mmnn <br>
1052: mmnn<br>
3412: nn <br>
What is the correct code?",


"Ron Weasley bought a magical die having 10 sides(numbered  1 to 10) from  Zonko's Joke Shop in hogsmeade.<br>In this die all the even numbered sides are colored blue and all odd numbered sides are colored white. He wants to find the probabilty of getting a blue color and number 9 in a single throw. Answer him.(answer rounded to 3 decimal places) ",



"In a certain code, 'TRIAL' is written as 'UQJZM'. How is 'SIKKIM' written in the code?",




"The speed of a bus is 160 km/hr. When a cart load of x is connected, the speed of the bus decreases which is given by the function x^2 +4x-4. What is the minimum speed of the bus.",



"In a class of 51 students, a1, a2, a3….…a50, a51 are the marks obtained by the students in descending order.  If a1 is excluded, the average decreases by 1% and if a51 is excluded, the average increases by 4/3%.  What is the original average score of the class?",


"Mr. Berty's office had an old copying machine and a new one. The older of the two machines take 5 hours to make all copies of a report, while the other machine takes only 3 hours to do the same. He decides to use both the machines to make copies of his report. How long will it take for the job to be completed, if both the machines are used? <br> (Input your answer in number of hours taken. If it takes 6 hours, then input as: 6 )",



"Ten people decided to start a club and all the 10 have put equal amount. If there had been five more in the group, the initial expense to each would have been $100 less. What was the initial cost per person (in $)?",


"What is the value of the product of <br>(19+25) * (19+23) * (19+21) … (19-25)?",



"If <br> 
3366 / 13 = 3162 <br>
9876 - 4545 = 881371 <br>
then what is : 1234 + 5678 =? <br>",



"A dishonest milkman sells his milk at cost price but he mixes it with water and thereby gains 50%. What is the percentage of water in the mixture? <br>(Answer rounded to two decimal places)",




"Ramesh and Suresh are playing a game. They are starting off with 300 coins. Each one has to pick atleast 1 coin and atmost 7 coins. The last one to pick a coin wins. Considering both play optimally, how many coins should Ramesh pick initially in order to win the game?",




"In the year 1356, Suresh was Y years old, where 13xx is the square of Y. How old was he in 1342?",



"Four cards, 0,1, 2 and 6, can be used to display times, like 12:06. Using a 24-hour clock, how many different actual times can be created by rearranging the cards? You must use all four cards each time, and the cards cannot be overlapped.",



"Haley Dunphy finally found out what she wants to do with her life!She wants to become a writer for Alette fashion magazine.She has compiled all the articles she has posted in her fashion blog as a 1000 page book and sent it to the editor of Alette. She has 500 selfies of hers in the book(because she considers herself as a style icon and most of her articles is about the clothes she wears). Find out probability that there are atleast 2 pictures of her in page 67.

<br>(round off to 2 decimal places)",


"Find ?<br>
<img src='http://kurukshetra.org.in/cerebra/assets/images/2.png'></img><br>
<img src='http://kurukshetra.org.in/cerebra/assets/images/3.png'></img><br>
<img src='http://kurukshetra.org.in/cerebra/assets/images/4.png'></img><br>

",

"The average current age of B, A, their daughter and their son who is just born is 22.5 years. Their daughter was born 10 years ago. The average age of B, his parents and A, 15 years back was 38.75 years. The average age of B and his parents, 20 years back, was 38.33 years. What is A’s present age?",



"Let the function partition(p,q) denote the number of ways you can partition a p element set into q non-empty subsets. Then what is the value of partition(4,2)?",




"Meena throws 5 dices at the same time. The product of the numbers on the face is 216. What is the middle sum( not greatest, not least) that can be obtained? -- Can change this question to lowest or highest sum in case find it confusing.",



"Professor Marvin gave marks based upon an average of a series of test. As John came to the last test, he realized that, he would have to make a 97 in order to average 90 for the course. On the other hand, if he was as low as 73, he would still be able to average 87. How many tests were there in Professor Marvin's series?",


"SS, MT, WT, ? <br>",



"In 'Perinopica', there was a circular playground. There are four points of entry into the playground – A, B, C and D. Three routes were constructed which joined AB, CD and AD. AB=10 and CD=7. Later the township extended the routes AB and CD past B and C respectively and they meet at a point E on the sidewalk outside the playground. If BE=8 and angle (AED) = 60 degrees, find the area enclosed by the routes AE, ED and AD. <br>(Answer closest to the nearest integer).",



"1.  write a list of consecutive integers from Z to 2 (Z, Z-1, Z-2, ..., 3, 2)..<br>
2.  assign  A equal to  Z.<br>
3. Circle  all the proper divisors of A (i.e. Remember that A is not circled).<br>
4. Find the largest  number from 2 to A – 1 that is not circled yet, and now let A  equal this number.<br>
5. If there were no more  numbers in the list which are not circled, STOP. Otherwise, repeat from step 3.<br>
If z=333 how many numbers will remain in the list at the end which are not circled.",



"X's mother's father is the husband of Y's mother. If X and Y are both male, how is X related to Y? <br>(Answer in lower case without any spaces. If needed use ‘–‘ eg: brother-in-law)",


"Cool numbers are numbers whose prime factors are 2,3 or 5.<br>
First cool number is 1,second cool number is 2. Similarly 7th cool number is 8.<br>
What is 150th cool number ? ",



"A set contains all possible 8 digit numbers that can be formed using the digits from 1 to 8 without any repetition. If an element of the set is selected at random, find the probability that if any five consecutive positions of the selected number are taken, the product of the digits of these positions is divisible by5. <br>(Answer close to 2 decimal places i.e. 0.xy)",


"The height of Mike was 6 metres above sea level. He was standing on a ship south of a light house and observed his shadow to be 24 metres long as measured at sea level.  Now the ship travels 300 metres eastwards and now he observes that his shadow is 300 metres long measured at sea level. What is the height of the light house in metres measured above sea level?",


"A 2 year old child started learning addition but he has not yet learnt how to carry. He knows 2+4=6 but cannot calculate 3+9. How many pairs of consecutive natural numbers from 1000 to 2000 can the child add?",


"If<br>
Q(4) = 4<br>
Q(11) = 143<br>
Q(16) = 1596<br>
then what is Q(23)?
",

"<br><img src='http://kurukshetra.org.in/cerebra/assets/images/5.png'></img><br>
Find the area in cm^2 of the shaded region, if the inner circles are all of same radius 7cm and the outer circle is of radius 16cm.
Format: Round off to the nearest integer. ",


"If two smaller faces are congruent and the remaining four larger faces are congruent in a cuboid and each face is to be painted using the colours blue or red, what is the number of distinct cuboids that can be obtained?",


"Find the next term in the series: <br>
1,2,12,288,___ ",


"Decode the following: <br>
raydarnkij <br>
(HINT: You will need the name of a cipher)"

);

    $p     = $rr1->points;
    $answered     = $rr1->answered;//total no of questions answered.
    $totalquestions=count($ques)-1;
    date_default_timezone_set('Asia/Calcutta');
    $t=time();
    $rs = $this->db->query("select st_time from start_cerebra");
        $rem=0;
        if ($rs->num_rows() == 1) {
            $rrs     = $rs->row();
            $st_time = $rrs->st_time;
            $rem=$t-human_to_unix($st_time);
?>
<script type="text/javascript">
      var phptimestamp = "<? echo human_to_unix($st_time)+5400;?>";      
       
    </script>
<?
            //$diff    = $t - $st_time;
            //$rem     = ($diff + 109899) - $t;
      $flag=1;
    }
    
  if($rem<=0){
      $msg="<h2>Please wait till 20:00 IST !!</h2></div>";
            $flag=0;
    }
    
    if($flag==1){
      if($rem>=5400)
      {
        $msg="<h2>Cerebra main contest ended !! </h2></div>";
        $flag=0;
      }
    }
    

        
          

    //  $time_dif=$t-human_to_unix($st_time);        
      ///////////////////////////////////////////////////////////
      $totalques=count($ques);
      $code='</h2><div class="col-md-9 question">';
      
      
      if($totalquestions==$answered)
      {
        $code.="<h2>You have completed!!</h2>";
        $code.="</div>";
      }
      else if($flag==0){
        $code.=$msg;
      }
      
      else{
          $code.='<div id="fixed-div">
<div class="row"><div id="countdown"></div>
<div align="left" style="display:inline;">Points : &nbsp' . $p . '</div></div></div>
    <script>
    // set the date were counting down to

var target_date =new Date(phptimestamp*1000);
 
// variables for time units
var days, hours, minutes, seconds;
 
// get tag element
 
// update the tag with id "countdown" every 1 second
setInterval(function () {
 
    // find the amount of "seconds" between now and target
    var current_date = new Date().getTime();
    var seconds_left = (target_date - current_date) / 1000;
 
    // do some time calculations
    
    seconds_left = seconds_left % 86400;
     
    hours = parseInt(seconds_left / 3600);
    seconds_left = seconds_left % 3600;
     
    minutes = parseInt(seconds_left / 60);
    seconds = parseInt(seconds_left % 60);
     if(minutes<=0 && hours==0)
 { 
if(seconds<=0) { location.reload(true); 
     document.getElementById("countdown").innerHTML="Time is Up !!" ; }
else document.getElementById("countdown").innerHTML="Time is  Running!!<br>"+ hours + "h: "+ minutes + "m: " + seconds + "s";
}
    // format countdown string + set tag value
if(seconds>=0 && minutes>0)
    document.getElementById("countdown").innerHTML = hours + "h: "+ minutes + "m: " + seconds + "s";  
 
}, 1000);
    </script><div id="mascot" class="col-md-4 col-md-offset-8 "></div></h3> 
      ';
          for ($u = 1; $u <$totalques; $u++) {

        if ($qa[$u]==0) {
        $code .= '<br>
        <b>Question ' . $u . '</b>
        <div class="span6"><b>Attempts : </b>&nbsp;
        <div style="display:inline;">' . $qw[$u] . '</div></div>

<!------------------------------------------------------------------------------------------------------------------------------>
      <form name="unanswered' .$u. '" method="post" action="http://kurukshetra.org.in/cerebra/submit">
      <input type="hidden" name="level" value="' .$u. '"/>
      <br>' . $ques[$u] . '<br>
      <br>
      <input type="text" class="form-control input-lg" name="answer" id="t' . $u . '" placeholder="Your Answer Here!!" tab-index="'.$u.'"/>
      <br><button type="submit" class="btn btn-primary btn-lg" id="but'.$u.'" style="float:right;"  >Submit</button>
      </form>';
                } 

      else {
            $code .= '<br><br><div clas="span4" ><div class="well alert-success round">
                  <b>Question ' . $u . '</b>
                  <div class="span4"><b>Attempts : </b>&nbsp;
                  <div id=athena_attempts_t' . $u . ' style="display:inline;">' . $qw[$u] . '</div></div>
                  <div class="span4"><div id=qc' . $u . ' style="display:inline;">
                  <strong>Answered Correctly!</strong></div><div id=qs' . $u . '></div></div></div></div>';
                }
          }
          
          
      }
      return $code;
  
  

}

public function getanswer($level,$answer,$kid)
{
  //return 10;
 $answer_arr=array("0","142", "0.25", "4", "congratulation", "1234", "2046", "07051892", "4", "5012", "0.000", "THLJJL", "24", "60", "1.875", "300", "0", "562819112312", "33.33", "4", "23", "10", "0.09","23", "40", "7", "18", "8", "FS", "125", "167", "nephew", "5832", "0.25", "106", "156", "46367", "146", "18", "34560", "paulwalker");
  
    date_default_timezone_set('Asia/Calcutta');
   $t  = time();


        $rs = $this->db->query("select st_time from start_cerebra");
        if ($rs->num_rows() == 1) {
            $rrs     = $rs->row();
            $st_time = $rrs->st_time;
            $diff    = $t - human_to_unix($st_time);
            if ($diff > 5400)
                return ;
                }

    if(trim($answer)==null) return;
    
    else{
    
     $this->db->select('points,answered');
    $r1 = $this->db->get_where('cerebra_users',array('kid'=>$kid));
  //  $q1="select points,answered from cerebra_users where kid='$kid'";
    //$r1= $this->db->query($q1);
    $rr1   = $r1->row();
       $this->db->select('qid,attempt,flag');
       $r2 = $this->db->get_where('k13_cerebra',array('kid'=>$kid));
    
    //$r2    = $this->db->query($q2);
    $rr2   = $r2->row();
    $qid=array();
    $i=1;
    foreach($r2->result() as $row)
      $qid[$i++]=$row->qid;



    $i=1;
    $qa=array();
    $qw=array();
    //$qa    = $rr2->flag;
    //$qw    = $rr2->attempt;
    foreach($r2->result() as $row)
      {
        $qa[$i]=$row->flag;
        $qw[$i] = $row->attempt;
        $i++;
      }
    
    $p     = $rr1->points;
    $answered     = $rr1->answered;
      if(strcmp(($answer),$answer_arr[$level])==0)
      {

        $p=$p+3;
        $answered=$answered+1;
///////////////////////////////////////////////
        $this->db->update('k13_cerebra', array('flag'=>1), array('kid' => $kid,'qid'=>$qid[$level]));
        //$qq = "update k13_cerebra set flag='1' where kid='$kid' and qid='$level'";
                //$this->db->query($qq);
                $this->db->update('cerebra_users', array('points'=>$p,'answered'=>$answered), array('kid' => $kid));
                //$ar = "update cerebra_users set points='$p',answered='$answered' where kid='$kid'";
                //$this->db->query($ar);

              }
      else
      {
        
        $attempt=$qw[$level];
        $attempt=$attempt+1;
        $p=$p-1;
        $this->db->update('k13_cerebra', array('attempt'=>$attempt), array('kid' => $kid,'qid'=>$level));
        $this->db->update('cerebra_users', array('points'=>$p), array('kid' => $kid));
        //$qq = "update k13_cerebra set attempt='$attempt' where kid='$kid' and qid='$level'";
        //$ar = "update cerebra_users set points='$points' where kid='$kid'";
        //$this->db->query($qq);
        //$this->db->query($ar);
      }
      
  }
}
}
