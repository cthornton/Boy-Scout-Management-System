                <h1>Select a Patrol</h1>
                <p>
                    It appears that you are not a part of a patrol. Please select a patrol from below if you want to
                    have access to the benifits of patrol related features. Note that the "Adults" and other groups are
                    also included.
                </p>
                
                <form action="?page=patrols" method="post">
                    <div class="iesucks">
                        <label for="ptrl">Patrol</label>
                        
                        <select name="ptrl">
                            <optgroup label="Patrols">
                            <?php
                            $spc = false;
                            
                            
                            foreach($var['ptrls'] as $arr)
                            {
                                
                                if($arr[2] == 1 && !$spc)
                                {
                                    $spc = true;
                                    
                                    echo '
                            </optgroup>
                            <optgroup label="Other">';
                                }
                                
                                
                                echo '
                                <option value="', $arr[0], '">', $arr[1], '</option>';
                            }
                            ?>
                            </optgroup>
                        </select>
                    </div>
                    
                    <div class="iesucks">
                        <label for="submit">&nbsp;</label>
                        <input type="submit" name="submit" value="Join Patrol">
                    </div>
                </form>
                    