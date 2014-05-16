<!DOCTYPE html> 
<html> 
<head> 
  <script type='text/javascript' src='http://code.jquery.com/jquery-1.4.4.min.js'></script> 
  <script type='text/javascript' src="js/jquery.tipsy.js"></script> 
  <script type='text/javascript'> 
  $(function(){
      $('input.focustip').tipsy({trigger: 'focus', gravity: 'w', fade: true});
      $('input.hovertip').tipsy({trigger: 'hover', gravity: 'w', fade: true});
  });
  </script> 
</head> 
<body> 
  <p>Test case for <a href="http://stackoverflow.com/q/4258519/445073">stackoverflow question</a>.</p> 
<p>Focus tip: <input class="focustip" title="focus"></input></p> 
<p>Hover tip: <input class="hovertip" title="hover"></input></p> 
</body> 
</html>