<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Output extends CI_Output
{
    private $JavascriptFiles = array();
    private $JavascriptTags = "";

    private $CSSFiles = array();
    private $CSSTags = "";

    //Add a javascript file to the array.
    public function javascript($File = null)
    {
        if($File && !in_array($File ,$this->JavascriptFiles))
        {
            $this->JavascriptFiles[] = $File;
        }
    }

    //Add a css file to the array.
    public function css($File = null)
    {
        if($File && !in_array($File ,$this->CSSFiles))
        {
            $this->CSSFiles[] = $File;
        }
    }

    //Build the javascript tags
    private function buildtags()
    {
        if(!empty($this->JavascriptFiles))
        {
            foreach($this->JavascriptFiles as $File) {
                $this->JavascriptTags .= "<script type=\"text/javascript\" src=\"$File\"></script>\n";
            }
        }

        if(!empty($this->CSSFiles))
        {
            foreach($this->CSSFiles as $File) {
                $this->CSSTags .= "<link type=\"text/css\" href=\"$File\" rel=\"stylesheet\" media=\"all\" />\n";
            }
        }
    }


    //Override the main output function that sends content to the browser
    //and slap in the javascript and css where we need it.
    function _display($output = '')
    {

        $this->buildtags();
        $this->final_output = str_replace("{VIEW_SPECIFIC_JAVASCRIPT}", $this->JavascriptTags, $this->final_output);
        $this->final_output = str_replace("{VIEW_SPECIFIC_CSS}", $this->CSSTags, $this->final_output);

        // SNIP----
        // Rest of method code follows from here
		// Note:  We use globals because we can't use $CI =& get_instance()
		// since this function is sometimes called by the caching mechanism,
		// which happens before the CI super object is available.
		global $BM, $CFG;

		// Grab the super object if we can.
		if (class_exists('CI_Controller'))
		{
			$CI =& get_instance();
		}

		// --------------------------------------------------------------------

		// Set the output data
		if ($output == '')
		{
			$output =& $this->final_output;
		}

		// --------------------------------------------------------------------

		// Do we need to write a cache file?  Only if the controller does not have its
		// own _output() method and we are not dealing with a cache file, which we
		// can determine by the existence of the $CI object above
		if ($this->cache_expiration > 0 && isset($CI) && ! method_exists($CI, '_output'))
		{
			$this->_write_cache($output);
		}

		// --------------------------------------------------------------------

		// Parse out the elapsed time and memory usage,
		// then swap the pseudo-variables with the data

		$elapsed = $BM->elapsed_time('total_execution_time_start', 'total_execution_time_end');

		if ($this->parse_exec_vars === TRUE)
		{
			$memory	 = ( ! function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2).'MB';

			$output = str_replace('{elapsed_time}', $elapsed, $output);
			$output = str_replace('{memory_usage}', $memory, $output);
		}

		// --------------------------------------------------------------------

		// Is compression requested?
		if ($CFG->item('compress_output') === TRUE && $this->_zlib_oc == FALSE)
		{
			if (extension_loaded('zlib'))
			{
				if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) AND strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE)
				{
					ob_start('ob_gzhandler');
				}
			}
		}

		// --------------------------------------------------------------------

		// Are there any server headers to send?
		if (count($this->headers) > 0)
		{
			foreach ($this->headers as $header)
			{
				@header($header[0], $header[1]);
			}
		}

		// --------------------------------------------------------------------

		// Does the $CI object exist?
		// If not we know we are dealing with a cache file so we'll
		// simply echo out the data and exit.
		if ( ! isset($CI))
		{
			echo $output;
			log_message('debug', "Final output sent to browser");
			log_message('debug', "Total execution time: ".$elapsed);
			return TRUE;
		}

		// --------------------------------------------------------------------

		// Do we need to generate profile data?
		// If so, load the Profile class and run it.
		if ($this->enable_profiler == TRUE)
		{
			$CI->load->library('profiler');

			if ( ! empty($this->_profiler_sections))
			{
				$CI->profiler->set_sections($this->_profiler_sections);
			}

			// If the output data contains closing </body> and </html> tags
			// we will remove them and add them back after we insert the profile data
			if (preg_match("|</body>.*?</html>|is", $output))
			{
				$output  = preg_replace("|</body>.*?</html>|is", '', $output);
				$output .= $CI->profiler->run();
				$output .= '</body></html>';
			}
			else
			{
				$output .= $CI->profiler->run();
			}
		}

		// --------------------------------------------------------------------

		// Does the controller contain a function named _output()?
		// If so send the output there.  Otherwise, echo it.
		if (method_exists($CI, '_output'))
		{
			$CI->_output($output);
		}
		else
		{
			echo $output;  // Send it to the browser!
		}

		log_message('debug', "Final output sent to browser");
		log_message('debug', "Total execution time: ".$elapsed);
	}
}