<footer class="footer border-top">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <!--<script>document.write(new Date().getFullYear())</script>-->
            &copy; <?=date("Y");?>. All Rights Reserved at <?=SITE_NAME?>  </div>
          <?php /*?><div class="col-sm-6">
            <div class="text-sm-end d-none d-sm-block"> Design & Develop by <?=SITE_NAME?> </div>
          </div><?php */?>
        </div>
      </div>
    </footer>
	
		
<script src="../nodejs/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@walletconnect/web3-provider@1.7.1/dist/umd/index.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/TrueFiEng/useDApp/packages/core/src/index.ts"></script>
<!-- <script src="../nodejs/jquery.toaster.js"></script>	 -->
<script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.36/dist/web3.min.js" integrity="sha256-nWBTbvxhJgjslRyuAKJHK+XcZPlCnmIAAMixz6EefVk=" crossorigin="anonymous"></script>
<script src="../nodejs/ido.js?<?=time();?>"></script>

 
  
   <script>
                        function myFunctionCopy() {
                            var copyText = document.getElementById("copyTarget");
                            copyText.select();
                            copyText.setSelectionRange(0, 99999);
                            document.execCommand("copy");
							//playSound();
							alert("Your referral link has been copied successfully!");
                            // var tooltip = document.getElementById("myTooltip");
                            // tooltip.innerHTML = "Copied: " + copyText.value;
                            /// tooltip.innerHTML = "Copied";
                         }
						
						 
   </script>