 
      
    $(document).ready(function() {
      
      postcontent();

      console.clear();

    });
    
    var postcont = $("#postcontent");
    
    var baseurl = document.getElementById("baseurl").value;
    var csrfName = $('.txt_csrfname').attr('name'); 
    var csrfHash = $('.txt_csrfname').val(); 
    
 
    function postcontentpaging(start){
    	$('#start').val(start);
      postcontent();  
    }
    function postcontent(){   
      var slugclub = document.getElementById("slugclub").value;
      var sluglaporan = document.getElementById("sluglaporan").value;

      $.ajax({
          url: baseurl+'/interface-postcontent-detail',
          type: 'POST',
          dataType: 'JSON',
          data:{[csrfName]: csrfHash,slugclub:slugclub,sluglaporan:sluglaporan},    
          success: function(response) {
            $('.txt_csrfname').val(response.csrf_token_name);

            if(response.null != 0){
              document.getElementById("postcontent").style.display = "block";
              document.getElementById("postcontent").innerHTML = response.html;    
            }else{
              document.getElementById("postcontent").style.display = "none";
              document.getElementById("postcontent").innerHTML =""; 
            }

          }
      });
      
    }
    
 
    function sukainput(random){    
          $.ajax({
          url: baseurl+'/interface-like',
          type: 'POST',
          dataType: 'JSON',
          data:{[csrfName]: csrfHash,random:random},       
          success: function(data) {

            $('.txt_csrfname').val(data.csrf_token_name);
            if(data.nmr > 10){
              postcontentscroll();
            }else{
              postcontent();
            }
            
          }
      });
      
    }
    function sukafalseinput(random){    
      $.ajax({
          url: baseurl+'/interface-false-like',
          type: 'POST',
          dataType: 'JSON',
          data:{[csrfName]: csrfHash,random:random},       
          success: function(data) {

            $('.txt_csrfname').val(data.csrf_token_name);
            if(data.nmr > 10){
              postcontentscroll();
            }else{
              postcontent();
            }
            
          }
      });
      
    }
        
    function komentarsave(kom)
    {

      var formData = new FormData($('#formkomentar'+kom)[0]);

      $.ajax({
          url : baseurl+'/interface-komentar-save',
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "JSON",
          success: function(data)
          {
            $('.txt_csrfname').val(data.csrf_token_name);
            $('#formkomentar'+kom)[0].reset();
            postcontent();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {

          }
      });
    }
    function komentardelete(random)
    {

      $.ajax({
          url : baseurl+'/interface-komentar-delete',
          type: 'POST',
          dataType: 'JSON',
          data:{[csrfName]: csrfHash,random:random},       
          success: function(data) {

            $('.txt_csrfname').val(data.csrf_token_name);
            postcontent();
            
          }
      });
    }
    function komentarbalas1(kom)
    {
      document.getElementById("btn-balas-komentar1/"+kom).style.display = "none";
      document.getElementById("btn-balas-komentar2/"+kom).style.display = "block";
      document.getElementById("balas-komentar"+kom).style.display = "block";
      document.getElementById("balaskomentar"+kom).style.display = "block";
    }
    function komentarbalas2(kom)
    {
      document.getElementById("btn-balas-komentar1/"+kom).style.display = "block";
      document.getElementById("btn-balas-komentar2/"+kom).style.display = "none";
      document.getElementById("balas-komentar"+kom).style.display = "none";
      document.getElementById("balaskomentar"+kom).style.display = "none";
    }
    function komentarsavesub(kom)
    {

      var formData = new FormData($('#formkomentarsub'+kom)[0]);

      $.ajax({
          url : baseurl+'/interface-komentar-save-sub',
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "JSON",
          success: function(data)
          {
            $('.txt_csrfname').val(data.csrf_token_name);
            $('#formkomentarsub'+kom)[0].reset();
            komentarbalas1(kom);
            postcontent();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {

          }
      });
    }
    function komentardeletesub(random)
    {

      $.ajax({
          url : baseurl+'/interface-komentar-delete-sub',
          type: 'POST',
          dataType: 'JSON',
          data:{[csrfName]: csrfHash,random:random},       
          success: function(data) {

            $('.txt_csrfname').val(data.csrf_token_name);
            postcontent();
            
          }
      });
    }
    function tampilkankomentarlainnya(kom)
    {
      document.getElementById("tampilkankomentarlainnya"+kom).style.display = "none";
      document.getElementById("komentarlainnya"+kom).style.display = "block";
      document.getElementById("sembunyikankomentarlainnya"+kom).style.display = "block";
    }
    function sembunyikankomentarlainnya(kom)
    {
      document.getElementById("tampilkankomentarlainnya"+kom).style.display = "block";
      document.getElementById("komentarlainnya"+kom).style.display = "none";
      document.getElementById("sembunyikankomentarlainnya"+kom).style.display = "none";
    }

    