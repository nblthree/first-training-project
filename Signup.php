<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="signup_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<title>Signup</title>
</head>
<body>
<div id="op"></div>
<div id="signup">
<div id="si">
	<div id="s1"><h3>Sign up</h3></div>
	<div id="form">
		<div id="s2"><input class='eparent' id="pseudonyme" type="text" name="pseudo" placeholder="Username" maxlength="120" ></div>
		<span id="tooltip1" style="display: none">Username already used.</span>
    <span id="e1" class="e" style="display: none"></span>
		<div id="s2"><input class='eparent' type="text" name="email" id="email" placeholder="E-mail" maxlength="120"></div>
    <span id="e2" class="e" style="display: none"></span>
		<div id="s2"><input class='eparent' id="pw1" type="password" name="pass" placeholder="Password." maxlength="100"></div>
		<span id="tooltip2" >Password must have more than 10 charachters.</span>
    <span id="e3" class="e" style="display: none"></span>
		<div id="s2"><input class='eparent' id="pw2" type="password" name="passconfirme" placeholder="Re-enter password" maxlength="100"></div>
		<span id="tooltip3" style="display: none">Passwords not identical.</span>
    <span id="e4" class="e" style="display: none"></span>
		<div class="select-style1"><label>Birthdate</label><br><select name="day" id='day'>
      <option value="01" selected="selected">01</option>
		<?php
		                 $i=2;
		                 while ($i<32) {
	    ?>
                     <option value="<?php if ($i<10) { echo "0$i";} else{ echo $i; } ?>"><?php if ($i<10) {
                         echo "0$i";}
                         else{
    	                 echo $i;
                              } 
        ?>           </option>
        <?php
            $i++;
                                        }
        ?>
                     </select>
                     <select name="month" id="month">
    <option value="01" selected="selected">January</option>
    <option value="02">February</option>
    <option value="03">March</option>
    <option value="04">April</option>
    <option value="05">May</option>
    <option value="06">June</option>
    <option value="07">July</option>
    <option value="08">August</option>
    <option value="09">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
                     </select>
                     <select name="year" id="year">
                      <option selected="selected">1950</option>
		<<?php
		                 $i=1951;
		                 while ($i<= date('Y')) {
	    ?>
                     <option><?php echo $i; ?></option>
        <<?php
            $i++;
                                        }
        ?>
                     </select></div>
<div class="select-style2">
<select name="country" id="country">
<option value="NULL" label="Country" selected="selected">Country</option>
</optgroup>
<optgroup id="country-optgroup-Americas" label="Americas">
<option value="AI" label="Anguilla">Anguilla</option>
<option value="AG" label="Antigua and Barbuda">Antigua and Barbuda</option>
<option value="AR" label="Argentina">Argentina</option>
<option value="AW" label="Aruba">Aruba</option>
<option value="BS" label="Bahamas">Bahamas</option>
<option value="BB" label="Barbados">Barbados</option>
<option value="BZ" label="Belize">Belize</option>
<option value="BM" label="Bermuda">Bermuda</option>
<option value="BO" label="Bolivia">Bolivia</option>
<option value="BR" label="Brazil">Brazil</option>
<option value="VG" label="British Virgin Islands">British Virgin Islands</option>
<option value="CA" label="Canada">Canada</option>
<option value="KY" label="Cayman Islands">Cayman Islands</option>
<option value="CL" label="Chile">Chile</option>
<option value="CO" label="Colombia">Colombia</option>
<option value="CR" label="Costa Rica">Costa Rica</option>
<option value="CU" label="Cuba">Cuba</option>
<option value="DM" label="Dominica">Dominica</option>
<option value="DO" label="Dominican Republic">Dominican Republic</option>
<option value="EC" label="Ecuador">Ecuador</option>
<option value="SV" label="El Salvador">El Salvador</option>
<option value="FK" label="Falkland Islands">Falkland Islands</option>
<option value="GF" label="French Guiana">French Guiana</option>
<option value="GL" label="Greenland">Greenland</option>
<option value="GD" label="Grenada">Grenada</option>
<option value="GP" label="Guadeloupe">Guadeloupe</option>
<option value="GT" label="Guatemala">Guatemala</option>
<option value="GY" label="Guyana">Guyana</option>
<option value="HT" label="Haiti">Haiti</option>
<option value="HN" label="Honduras">Honduras</option>
<option value="JM" label="Jamaica">Jamaica</option>
<option value="MQ" label="Martinique">Martinique</option>
<option value="MX" label="Mexico">Mexico</option>
<option value="MS" label="Montserrat">Montserrat</option>
<option value="AN" label="Netherlands Antilles">Netherlands Antilles</option>
<option value="NI" label="Nicaragua">Nicaragua</option>
<option value="PA" label="Panama">Panama</option>
<option value="PY" label="Paraguay">Paraguay</option>
<option value="PE" label="Peru">Peru</option>
<option value="PR" label="Puerto Rico">Puerto Rico</option>
<option value="BL" label="Saint Barthélemy">Saint Barthélemy</option>
<option value="KN" label="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
<option value="LC" label="Saint Lucia">Saint Lucia</option>
<option value="MF" label="Saint Martin">Saint Martin</option>
<option value="PM" label="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
<option value="VC" label="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
<option value="SR" label="Suriname">Suriname</option>
<option value="TT" label="Trinidad and Tobago">Trinidad and Tobago</option>
<option value="TC" label="Turks and Caicos Islands">Turks and Caicos Islands</option>
<option value="VI" label="U.S. Virgin Islands">U.S. Virgin Islands</option>
<option value="US" label="United States">United States</option>
<option value="UY" label="Uruguay">Uruguay</option>
</optgroup>
<optgroup id="country-optgroup-Asia" label="Asia">
<option value="CN" label="China">China</option>
<option value="CY" label="Cyprus">Cyprus</option>
<option value="GE" label="Georgia">Georgia</option>
<option value="ID" label="Indonesia">Indonesia</option>
<option value="JP" label="Japan">Japan</option>
<option value="LB" label="Lebanon">Lebanon</option>
<option value="SG" label="Singapore">Singapore</option>
<option value="KR" label="South Korea">South Korea</option>
<option value="SY" label="Syria">Syria</option>
<option value="TR" label="Turkey">Turkey</option>
<option value="VN" label="Vietnam">Vietnam</option>
</optgroup>
<optgroup id="country-optgroup-Europe" label="Europe">
<option value="AL" label="Albania">Albania</option>
<option value="AD" label="Andorra">Andorra</option>
<option value="AT" label="Austria">Austria</option>
<option value="BY" label="Belarus">Belarus</option>
<option value="BE" label="Belgium">Belgium</option>
<option value="BA" label="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
<option value="BG" label="Bulgaria">Bulgaria</option>
<option value="HR" label="Croatia">Croatia</option>
<option value="CY" label="Cyprus">Cyprus</option>
<option value="CZ" label="Czech Republic">Czech Republic</option>
<option value="DK" label="Denmark">Denmark</option>
<option value="DD" label="East Germany">East Germany</option>
<option value="EE" label="Estonia">Estonia</option>
<option value="FO" label="Faroe Islands">Faroe Islands</option>
<option value="FI" label="Finland">Finland</option>
<option value="FR" label="France">France</option>
<option value="DE" label="Germany">Germany</option>
<option value="GI" label="Gibraltar">Gibraltar</option>
<option value="GR" label="Greece">Greece</option>
<option value="GG" label="Guernsey">Guernsey</option>
<option value="HU" label="Hungary">Hungary</option>
<option value="IS" label="Iceland">Iceland</option>
<option value="IE" label="Ireland">Ireland</option>
<option value="IM" label="Isle of Man">Isle of Man</option>
<option value="IT" label="Italy">Italy</option>
<option value="JE" label="Jersey">Jersey</option>
<option value="LV" label="Latvia">Latvia</option>
<option value="LI" label="Liechtenstein">Liechtenstein</option>
<option value="LT" label="Lithuania">Lithuania</option>
<option value="LU" label="Luxembourg">Luxembourg</option>
<option value="MK" label="Macedonia">Macedonia</option>
<option value="MT" label="Malta">Malta</option>
<option value="FX" label="Metropolitan France">Metropolitan France</option>
<option value="MD" label="Moldova">Moldova</option>
<option value="MC" label="Monaco">Monaco</option>
<option value="ME" label="Montenegro">Montenegro</option>
<option value="NL" label="Netherlands">Netherlands</option>
<option value="NO" label="Norway">Norway</option>
<option value="PL" label="Poland">Poland</option>
<option value="PT" label="Portugal">Portugal</option>
<option value="RO" label="Romania">Romania</option>
<option value="RU" label="Russia">Russia</option>
<option value="SM" label="San Marino">San Marino</option>
<option value="SK" label="Slovakia">Slovakia</option>
<option value="SI" label="Slovenia">Slovenia</option>
<option value="ES" label="Spain">Spain</option>
<option value="SJ" label="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
<option value="SE" label="Sweden">Sweden</option>
<option value="CH" label="Switzerland">Switzerland</option>
<option value="UA" label="Ukraine">Ukraine</option>
<option value="GB" label="United Kingdom">United Kingdom</option>
<option value="VA" label="Vatican City">Vatican City</option>
<option value="AX" label="Åland Islands">Åland Islands</option>
</optgroup>
</select>
                    </div>
		<div id="s4"><button id='send' type="submit" >Creat an account</button></div>
    <span id="e5" class="e" style="display: none"></span>
	</div>
  </div>
</div>


<footer>
	<span>©2018 QuizBowl</span>
</footer>

<script>

        tooltip1.style.display = 'none';
        tooltip2.style.display = 'none';
        tooltip3.style.display = 'none';

        var pw1 = document.getElementById('pw1');
        var sp1 = document.getElementById('tooltip2');

        var anUpperCase = /[A-Z]/;
        var aLowerCase = /[a-z]/; 
        var aNumber = /[0-9]/;

pw1.addEventListener('keyup', function() {
  if(pw1.value.length == 0){
    sp1.style.display = 'none';
  }else if(!aLowerCase.test(pw1.value)){
    sp1.style.display = 'inline-block';
    sp1.textContent = "Password must contain a lower case.";
  }else if(!anUpperCase.test(pw1.value)){
    sp1.style.display = 'inline-block';
    sp1.textContent = "Password must contain an upper case.";
  }else if(!aNumber.test(pw1.value)){
    sp1.style.display = 'inline-block';
    sp1.textContent = "Password must contain number.";
  }else if (pw1.value.length < 10) {
    sp1.style.display = 'inline-block';
    sp1.textContent = "Password must have more than 10 charachters.";
  }else{
    sp1.style.display = 'none';
  }
  });

        var pw2 = document.getElementById('pw2');
        var sp2 = document.getElementById('tooltip3');
       pw2.addEventListener('keyup', function() {
      if (pw2.value === pw1.value) {
      	sp2.style.display = 'none';
      }
      else{
      	sp2.style.display = 'inline-block';
      }
  });

    var pseudonyme = document.getElementById('pseudonyme');
    var sp = document.getElementById('tooltip1');
    var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/? ]+/;
	pseudonyme.addEventListener('keyup', function() {
if(format.test($("#pseudonyme").val())){
  sp.innerHTML = "Special charachters ans whitespace are not allowed";
  sp.style.display = 'inline-block';
} else {
 $.post(
 	"t.php",
    {
        pseu : $("#pseudonyme").val()
    },
                function(data){ 
                	if (data == 1) {
                    sp.innerHTML = "Username already used.";
                		sp.style.display = 'inline-block';
                	}
                	else{
                		sp.style.display = 'none';
                	}
            },

            'text'
         );
}

}); 

$('.eparent').on('focus', function(){
  for (var i = 0; i < 5; i++) {
    document.getElementById('e'+Number(i+1)).style.display = 'none';
  }
});


var slides = document.getElementsByTagName('option');
for(var i = 0; i < slides.length; i++)
{
  if(typeof(slides[i].value)=='string' && slides[i].value.length == 2 && slides[i].parentElement.getAttribute('name')!='month'){
   slides[i].value = slides[i].innerHTML;
  } 
}

document.getElementById('send').addEventListener('click', function(){
  $.post(
  "function.php",
    {
        pseudo : $("#pseudonyme").val(),
        email : $("#email").val(),
        pass : $("#pw1").val(),
        passconfirme : $("#pw2").val(),
        day : $("#day").val(),
        month : $("#month").val(),
        year : $("#year").val(),
        country : $("#country").val()
    },
                function(data){
if(data.split(',').length == 5){
  sp.style.display = 'none';
  sp2.style.display = 'none';
  var data = data.split(',');
  for (var i = 0; i < data.length; i++) {
    if(data[i].length > 0){
var e = document.getElementById("e"+Number(i+1));
e.textContent = data[i];
e.style.display = 'inline-block';
    }
  }
}else if(data.split(',').length == 2 && data.split(',')[1]=='pseudo'){
  window.location.href = "confirm.php?pseudo="+data.split(',')[0];
}
                },

            'text'
         );
});



</script>
</body>
</html>
