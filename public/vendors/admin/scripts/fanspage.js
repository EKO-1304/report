 
      
    $(document).ready(function() {
      
      videotab();
      fototabalbum();
      fototab();
      fotoleft();
      videoleft();
      postcontent();

      console.clear();

    });
    

    $('textarea').keyup(function() {
        
      var characterCount = $(this).val().length,
          current = $('#current'),
          maximum = $('#maximum'),
          theCount = $('#the-count');
        
      current.text(characterCount);
    
      
      /*This isn't entirely necessary, just playin around*/
      if (characterCount < 70) {
        current.css('color', '#666');
      }
      if (characterCount > 70 && characterCount < 90) {
        current.css('color', '#6d5555');
      }
      if (characterCount > 90 && characterCount < 100) {
        current.css('color', '#793535');
      }
      if (characterCount > 100 && characterCount < 120) {
        current.css('color', '#841c1c');
      }
      if (characterCount > 120 && characterCount < 139) {
        current.css('color', '#8f0001');
      }
      
      if (characterCount >= 140) {
        maximum.css('color', '#8f0001');
        current.css('color', '#8f0001');
        theCount.css('font-weight','bold');
      } else {
        maximum.css('color','#666');
        theCount.css('font-weight','normal');
      }
      
          
    });
   function auto_grow(element) {
        element.style.height = "25px";
        element.style.height = (element.scrollHeight)+"px";
    }

    var wrap = $("#videofoto");
    var postcont = $("#postcontent");

    $(window).scroll(function(){
      var position = Math.ceil($(window).scrollTop());
      var bottom = $(document).height() - $(window).height();
      var heighttab = $(".heighttab").height();
      var jumlah = 500+heighttab;

      // var total = position+' - '+bottom+' - '+jumlah;
    	// $('#sizescroll').val(total);

      // console.log(total);
        if( position >= jumlah ){
          wrap.addClass("videofotostop");
          postcont.addClass("csspostcontent");
        } else {
          wrap.removeClass("videofotostop");
          postcont.removeClass("csspostcontent");
        }

    });
    
    var baseurl = document.getElementById("baseurl").value;
    var csrfName = $('.txt_csrfname').attr('name'); 
    var csrfHash = $('.txt_csrfname').val(); 
    
 
    function postcontentpaging(start){
    	$('#start').val(start);
      postcontent();  
    }
    function postcontent(){   
      var random = document.getElementById("resultclub").value;
      var start = Number($('#start').val());
      var rowperpage = Number($('#rowperpage').val());

      $.ajax({
          url: baseurl+'/interface-postcontent',
          type: 'POST',
          dataType: 'JSON',
          data:{[csrfName]: csrfHash,random:random,start:start,rowperpage:rowperpage},    
          success: function(response) {
            $('.txt_csrfname').val(response.csrf_token_name);

            if(response.null != 0){
              document.getElementById("postcontent").style.display = "block";
              document.getElementById("postcontent").innerHTML = response.html;   
              document.getElementById("pagercontent").innerHTML = response.pagercontent;      
            }else{
              document.getElementById("postcontent").style.display = "none";
              document.getElementById("postcontent").innerHTML =""; 
              document.getElementById("pagercontent").innerHTML =""; 
            }

          }
      });
      
    }
    
    function postcontentscroll(){    
      var random = document.getElementById("resultclub").value;
      var start = Number($('#start').val());
      var allcount = Number($('#totalrecords').val());
      var rowperpage = Number($('#rowperpage').val());
      start = start + rowperpage;

   		if(start <= allcount){
    		$('#start').val(start);

        $.ajax({
            url: baseurl+'/interface-postcontent-scroll',
            type: 'POST',
            dataType: 'JSON',
            data:{[csrfName]: csrfHash,random:random,start:start,rowperpage:rowperpage},  
            beforeSend: function(){
            $('#loader-icon').show();
            },  
            complete: function(){
            $('#loader-icon').hide();
            },
            success: function(response){
              // Add
                $(".postscroll:last").after(response.html).show().fadeIn("slow");
                // Update token
                $('.txt_csrfname').val(response.csrf_token_name);
            }
        });
      }
      
    }
    // $(window).scroll(function() {
    //   if(Math.ceil($(window).scrollTop()) + $(window).height() >= $(document).height()){
    //     //Your code here
    //       postcontentscroll();	
    //   }
    // });
    
 
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
    function fototabalbum(){    
      var random = document.getElementById("resultclub").value;
      $.ajax({
          url: baseurl+'/interface-foto-album',
          type: 'POST',
          dataType: 'JSON',
          data:{[csrfName]: csrfHash,random:random},       
          success: function(data) {
            $('.txt_csrfname').val(data.csrf_token_name);

            let html = '';
            var i;
            
            const x_link = data.link;
            const x_ng = data.namagaleri;
            const x_countaall = data.countaall;

            if(data.null != 0){
              for(let i=0; i< x_link.length; i++){                             										
                html += '<div class="col-sm-3 mb-20">';
                html += '<img src="'+x_link[i]+'" class="img-fluid rounded" style="width:100%" >';
                html += '<span>'+x_ng[i]+'</span><br><span class="text-muted">'+x_countaall[i]+' Items</span>';
                html += '</div>';
              }
              // document.getElementById("foto-left").style.display = "block";
              document.getElementById("foto-view-tab-album").innerHTML = html;       
            }else{
              // document.getElementById("foto-left").style.display = "none";
              document.getElementById("foto-view-tab-album").innerHTML =""; 
            }

          }
      });
      
    }
    function fototab(){    
      var random = document.getElementById("resultclub").value;

      $.ajax({
          url: baseurl+'/interface-foto-tab',
          type: 'POST',
          dataType: 'JSON',
          data:{[csrfName]: csrfHash,random:random},       
          success: function(data) {
            $('.txt_csrfname').val(data.csrf_token_name);

            let html = '';
            var i;
            
            const x_link = data.link;

            if(data.null != 0){
              for(let i=0; i< x_link.length; i++){                             										
                html += '<div class="col-sm-3 mb-20"><a href="'+x_link[i]+'" data-fancybox="images" ><img src="'+x_link[i]+'" alt="" class="img-fluid rounded" style="width:100%"></a></div>';
              }
              // document.getElementById("foto-left").style.display = "block";
              document.getElementById("foto-view-tab").innerHTML = html;       
            }else{
              // document.getElementById("foto-left").style.display = "none";
              document.getElementById("foto-view-tab").innerHTML =""; 
            }

          }
      });
      
    }
    function fotoleft(){    
      var random = document.getElementById("resultclub").value;
      $.ajax({
          url: baseurl+'/interface-foto-left',
          type: 'POST',
          dataType: 'JSON',
          data:{[csrfName]: csrfHash,random:random},       
          success: function(data) {
            $('.txt_csrfname').val(data.csrf_token_name);

            if(data.null != 0){
              document.getElementById("foto-left").style.display = "block";
              document.getElementById("foto-view-left").innerHTML = data.html;       
            }else{
              document.getElementById("foto-left").style.display = "none";
              document.getElementById("foto-view-left").innerHTML =""; 
            }

          }
      });
      
    }
    function videotab(){    
      var random = document.getElementById("resultclub").value;
      $.ajax({
          url: baseurl+'/interface-video-tab',
          type: 'POST',
          dataType: 'JSON',
          data:{[csrfName]: csrfHash,random:random},       
          success: function(data) {
            $('.txt_csrfname').val(data.csrf_token_name);

            let html = '';
            var i;
            
            const x_video = data.video;
            const x_judul = data.judul;

            if(data.null != 0){
              for(let i=0; i< x_video.length; i++){
                html += '<div class="col-sm-4 mb-20">';                                   										
                // html += '<div><iframe class="rounded" allowfullscreen="" frameborder="0" height="200" src="http://www.youtube.com/embed/'+x_video[i]+'" width="100%"></iframe></div>';
                html += '<div><a href="https://www.youtube.com/watch?v='+x_video[i]+'" target="_blank"><img src="http://img.youtube.com/vi/'+x_video[i]+'/maxresdefault.jpg"  alt="" class="img-fluid rounded" style="width:100%"></a></div>';
                html += '<div><a href="#" target="_blank" class="text-capitalize font-weight-bold"  style="font-size:13px;">'+x_judul[i]+'</a></div>';
                html += '</div>';
              }
              // document.getElementById("video-left").style.display = "block";
              document.getElementById("video-tab").innerHTML = html;       
            }else{
              // document.getElementById("video-tab").style.display = "none";
              document.getElementById("video-tab").innerHTML =""; 
            }

          }
      });
      
    }
    function videoleft(){    
      var random = document.getElementById("resultclub").value;
      $.ajax({
          url: baseurl+'/interface-video-left',
          type: 'POST',
          dataType: 'JSON',
          data:{[csrfName]: csrfHash,random:random},       
          success: function(data) {
            $('.txt_csrfname').val(data.csrf_token_name);

            if(data.null != 0){
              document.getElementById("video-left").style.display = "block";  
              document.getElementById("video-left-desc").innerHTML =data.html;       
            }else{
              document.getElementById("video-left").style.display = "none";
              document.getElementById("video-left-desc").innerHTML =""; 
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

    