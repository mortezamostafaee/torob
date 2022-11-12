        <p id="dlr-footer">
            <?php echo $header['_dlr_description']; ?>
        </p>
      
    </div>
        
    </main>
    
    <?php 
    if(!isset($_GET['type'])) {
        ?>
        <script>
            var now = Date.now()/1000;
            var time = Number(localStorage.getItem('dlr-start'));
            if( Math.floor(now-time) > resendTime ){
                localStorage.clear();
            }
        </script>
        <?php
    }
    ?>
    
    <?php if( isset($_GET['type']) ) echo '<script>dlrTimer();</script>'; ?>
    
    </body>
    
</html>