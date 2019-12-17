

$(document).ready(function() {
  $("#kinput").change(function(){
    check()
  });
  $("#ninput").change(function(){
    check()
  });
});



function check(){
  let k = parseInt($("#ninput").val());
  let n = parseInt($("#kinput").val());
  var wynik = 0;
  
  try{
    let result = countJacobi(n, k);
    $('#result').css("width","120px");
    $('#result').css("color","white");
    switch(result){
      case -1:
        $('#result').css("background-image","linear-gradient(#aa0000,#900000)");
        break;
      case 0:
        $('#result').css("background-image","linear-gradient(#222,#000)");
        break;
      case 1:
        $('#result').css("background-image","linear-gradient(#00aa00,#009000)");
        break;
    }
    $('#result').html(result);
    
  }
  catch(err){
    $('#result').css("color","black");
    $('#result').css("background-image","linear-gradient(#fff,#ddd)");
    $('#result').css("width","300px");
    $('#result').html(err.message);
  }
  console.log(MathJax);
  //MathJax.typesetPromise(); BUGGED
  //MathJax.Hub.Queue(["Typeset",MathJax.Hub,"#result"]); OLDER VERSION
}

function countJacobi(a, n){
  if (n % 2 == 0) {
    throw Error('n musi być nieparzyste');
  }
  if (a == 0)
    return 0;
  if (a == 1)
    return 1;
  let x = 0
  let y = a
  while (y % 2 == 0){
    y = y / 2
    x = x + 1
  }
  if (x%2 == 1 && (n % 8 == 3 || n % 8 == 5)){
    wynik = -1;
  }
  else{
    wynik = 1;
  }
  if (n % 4 == 3 && y % 4 == 3){
    wynik = -wynik;
  }
  if (y == 1){
    return wynik;
  }
  else{
    return wynik * countJacobi(n % y, y);
  }
}

    /*
function countJacobi(n, k) {//n / k
  if (k <= 0 || k % 2 == 0) {
    throw Error('Wrong arguments');
  }

  n = n % k;
  let t = 1;
  while (n != 0) {
    while (n % 2 == 0) {
      n /= 2;
      let r = k % 8;
      if (r == 3 || r == 5) {
        t = -t;
      }
    }
    [n, k] = [k, n]; //ECMA6

    if ((n % 4 == k % 4) == 3) {
      t = -t;
    }
    n = n % k;
  }
  if (k == 1) return t;
  else return 0;
}
*/
