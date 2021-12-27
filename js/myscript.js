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