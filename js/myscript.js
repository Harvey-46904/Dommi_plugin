jQuery( "#btn-planes" ).click(function() {
    if (jQuery("#form-mudanzas").is(':hidden')) {
        jQuery("#form-mudanzas").show();
        jQuery(".pq-planes").hide();
    } else {
        jQuery("#form-mudanzas").hide();
        jQuery(".pq-planes").hide();
    }

    
  });
  jQuery( "#btn-cotizar" ).click(function() {
    if (jQuery(".pq-planes").is(':hidden')) {
        jQuery(".pq-planes").show();
        jQuery("#form-mudanzas").hide();
    } else {
        jQuery(".pq-planes").hide();
        jQuery("#form-mudanzas").hide();
    }
   
  });

  !function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '340484174274402'); 
fbq('track', 'PageView');