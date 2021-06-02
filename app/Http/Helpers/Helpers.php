<?php

/*--------------------------------------------------------------------------------------------*/
/* ROLES */
/*--------------------------------------------------------------------------------------------*/

// Role admin sistem
if(!function_exists('role_admin_sistem')){
    function role_admin_sistem(){
        return 1;
    }
}

// Role admin grup
if(!function_exists('role_admin_grup')){
    function role_admin_grup(){
        return 2;
    }
}

// Role admin kantor
if(!function_exists('role_admin_kantor')){
    function role_admin_kantor(){
        return 3;
    }
}

/*--------------------------------------------------------------------------------------------*/
/* WEBSITE IDENTITY */
/*--------------------------------------------------------------------------------------------*/

// Get website name
if(!function_exists('get_website_name')){
    function get_website_name(){
        $data = DB::table('settings')->where('setting_key','website_name')->first();
        return $data->setting_value;
    }
}

// Get tagline
if(!function_exists('get_tagline')){
    function get_tagline(){
        $data = DB::table('settings')->where('setting_key','tagline')->first();
        return $data->setting_value;
    }
}

// Get email
if(!function_exists('get_email')){
    function get_email(){
        $data = DB::table('settings')->where('setting_key','email')->first();
        return $data->setting_value;
    }
}

// Get phone number
if(!function_exists('get_phone_number')){
    function get_phone_number(){
        $data = DB::table('settings')->where('setting_key','phone_number')->first();
        return $data->setting_value;
    }
}

// Get address
if(!function_exists('get_address')){
    function get_address(){
        $data = DB::table('settings')->where('setting_key','address')->first();
        return $data->setting_value;
    }
}

// Get logo
if(!function_exists('get_logo')){
    function get_logo(){
        $data = DB::table('settings')->where('setting_key','logo')->first();
        return $data->setting_value;
    }
}

// Get icon
if(!function_exists('get_icon')){
    function get_icon(){
        $data = DB::table('settings')->where('setting_key','icon')->first();
        return $data->setting_value;
    }
}

// Get map
if(!function_exists('get_map')){
    function get_map(){
        $data = DB::table('settings')->where('setting_key','map')->first();
        return $data->setting_value;
    }
}

/*--------------------------------------------------------------------------------------------*/
/* ARRAYS */
/*--------------------------------------------------------------------------------------------*/

// Array pesan validasi form
if(!function_exists('array_validation_messages')){
    function array_validation_messages(){
        $array = [
            'alpha' => 'Hanya bisa diisi dengan huruf!',
            'alpha_dash' => 'Hanya bisa diisi dengan huruf, angka, strip dan underscore!',
            'confirmed' => 'Tidak cocok!',
            'max' => 'Harus diisi maksimal :max karakter!',
            'min' => 'Harus diisi minimal :min karakter!',
            'numeric' => 'Harus diisi dengan nomor atau angka!',
            'required' => 'Harus diisi!',
            'unique' => 'Sudah terdaftar!',
        ];
        return $array;
    }
}

// Array nama bulan dalam Bahasa Indonesia
if(!function_exists('array_indo_month')){
    function array_indo_month(){
        $array = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        return $array;
    }
}

// Array jumlah hari dalam bulan
if(!function_exists('array_month_days')){
    function array_month_days($year){
        if($year % 4 == 0)
            $array = [31,29,31,30,31,30,31,31,30,31,30,31];
        else
            $array = [31,28,31,30,31,30,31,31,30,31,30,31];
        return $array;
    }
}

/*--------------------------------------------------------------------------------------------*/
/* GENERATE */
/*--------------------------------------------------------------------------------------------*/

// Generate umur / usia
if(!function_exists('generate_age')){
    function generate_age($date){
        $birthdate = new DateTime($date);
        $today = new DateTime('today');
        $old = $today->diff($birthdate)->old;
        return $old;
    }
}

// Generate tanggal
if(!function_exists('generate_date')){
    function generate_date($date){
        $explode = explode(" ", $date);
        $explode = explode("-", $explode[0]);
        return $explode[2]." ".array_indo_month()[$explode[1]-1]." ".$explode[0];
    }
}

// Generate format tanggal
if(!function_exists('generate_date_format')){
    function generate_date_format($date, $format){
        if($format == '/'){
            $explode = explode("-", $date);
            return $explode[2].'/'.$explode[1].'/'.$explode[0];
        }
        elseif($format == '-'){
            $explode = explode("/", $date);
            return $explode[2].'-'.$explode[1].'-'.$explode[0];
        }
        else
            return '';
    }
}

// Generate file dari folder
if(!function_exists('generate_file')){
    function generate_file($path, $exception_array = []){
		$dir = $path;
		$array = [];
		if(is_dir($dir)){
			if($handle = opendir($dir)){
    			// Loop file
           		while(($file = readdir($handle)) !== false){
                    // Pilih jika nama file bukan ".", "..", file bukan folder, serta file tidak dikecualikan
                    if($file != '.' && $file != '..' && !is_dir($dir.'/'.$file) && !in_array($file, $exception_array)){
                        array_push($array, $file);
                    }
            	}
            	closedir($handle);
        	}
    	}
		return $array;
    }
}

// Generate warna kebalikan
if(!function_exists('generate_inversion_color')){
    function generate_inversion_color($color){
        $hsl = rgb_to_hsl(hex_to_rgb($color));
        if($hsl->lightness > 200) return '#000000';
        else return '#ffffff';
    }
}

// Generate permalink
if(!function_exists('generate_permalink')){
    function generate_permalink($string){
        $result = strtolower($string);
        $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
        $result = preg_replace("/\s+/", " ",$result);
        $result = str_replace(" ", "-", $result);
        return $result;
    }
}

// Generate ukuran dari satuan byte
if(!function_exists('generate_size')){
    function generate_size($bytes){ 
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;
        $tb = $gb * 1024;

        if (($bytes >= 0) && ($bytes < $kb)) {
            return $bytes . ' B';
        } elseif (($bytes >= $kb) && ($bytes < $mb)) {
            return round($bytes / $kb) . ' KB';
        } elseif (($bytes >= $mb) && ($bytes < $gb)) {
            return round($bytes / $mb) . ' MB';
        } elseif (($bytes >= $gb) && ($bytes < $tb)) {
            return round($bytes / $gb) . ' GB';
        } elseif ($bytes >= $tb) {
            return round($bytes / $tb) . ' TB';
        } else {
            return $bytes . ' B';
        }
    }
}

// Generate header
if(!function_exists('generate_header')){
    function generate_header(){
        $menu = DB::table('menu')->where('menu_kategori','=','header')->first();
        $menu->menu = json_decode($menu->menu, true);
        return $menu->menu[0];
    }
}

// Generate footer
if(!function_exists('generate_footer')){
    function generate_footer(){
        $menu = DB::table('menu')->where('menu_kategori','=','footer')->first();
        $menu->menu = json_decode($menu->menu, true);
        return $menu->menu[0];
    }
}

// Generate header submenu
if(!function_exists('generate_header_submenu')){
    function generate_header_submenu($menu_name){
        $menu = DB::table('menu')->where('menu_kategori','=','header')->first();
        $menu->menu = json_decode($menu->menu, true);
		$menus = $menu->menu[0];
		$current_key = 0;
		foreach($menus as $key=>$submenu){
			if($submenu['name'] == $menu_name) $current_key = $key;
		}
		return $menus[$current_key]['children'][0];
    }
}

// Generate social media
if(!function_exists('generate_social_media')){
    function generate_social_media(){
        $socmed = DB::table('media_sosial')->where('link_medsos','!=','')->get();
        return $socmed;
    }
}

// Generate rule pada setting
if(!function_exists('generate_rule')){
    function generate_rule($key){
        $data = DB::table('settings')->where('setting_key',$key)->first();
        return $data->setting_rules;  
    }
}

// Generate share link
if(!function_exists('generate_share_links')){
    function generate_share_links($social_media, $title = ''){
        $links = Share::page(url()->full(), $title)->facebook()->twitter()->linkedin()->whatsapp()->telegram()->reddit()->getRawLinks();
        return array_key_exists($social_media, $links) ? $links[$social_media] : '';
    }
}

// Generate kantor
if(!function_exists('generate_kantor')){
    function generate_kantor($grup){
        // Get data kantor berdasarkan id_grup
        $kantor = DB::table('kantor')->where('id_grup','=',$grup)->get();
        return $kantor;
    }
}

/*--------------------------------------------------------------------------------------------*/
/* KHUSUSON E-GUDANG */
/*--------------------------------------------------------------------------------------------*/

// Default password
if(!function_exists('default_password')){
    function default_password(){
        return 'gudangaol';
    }
}

// Get data stok
if(!function_exists('get_data_stok')){
    function get_data_stok($barang, $bulan, $tahun, $kategori){
        $data = DB::table('stok')->where('id_barang','=',$barang)->where('bulan','=',$bulan)->where('tahun','=',$tahun)->first();
        if(!$data){
            $stok_terakhir = DB::table('stok')->where('id_barang','=',$barang)->orderBy('tahun','desc')->orderBy('bulan','desc')->first();
            if($stok_terakhir){
                if($kategori == 1) return $stok_terakhir->stok_akhir;
                elseif($kategori == 2) return 0;
                elseif($kategori == 3) return 0;
                elseif($kategori == 4) return $stok_terakhir->stok_akhir;
                elseif($kategori == 5) return 0;
                elseif($kategori == 6) return $stok_terakhir->stok_akhir;
                else return 0;
            }
            else return 0;
        }
        else{
            if($kategori == 1) return $data->stok_awal;
            elseif($kategori == 2) return $data->pembelian;
            elseif($kategori == 3) return $data->terjual;
            elseif($kategori == 4) return $data->sisa;
            elseif($kategori == 5) return $data->selisih;
            elseif($kategori == 6) return $data->stok_akhir;
            else return 0;
        }
    }
}

/*--------------------------------------------------------------------------------------------*/
/* OTHER METHODS */
/*--------------------------------------------------------------------------------------------*/

// Mengupload file
if(!function_exists('upload_file')){
    function upload_file($code, $path){
        // Decode base 64
        list($type, $code) = explode(';', $code);
        list(, $code)      = explode(',', $code);
        $code = base64_decode($code);
        $mime = str_replace('data:', '', $type);

        // Membuat nama file
        $file_name = date('Y-m-d-H-i-s');
        $file_name = $file_name.'.'.mime_to_ext($mime)[0];
        file_put_contents($path.$file_name, $code);

        // Return
        return $file_name;
    }
}

// Mengupload gambar dari Quill Editor
if(!function_exists('upload_quill_image')){
    function upload_quill_image($html, $path){
        // Mengambil gambar dari tag "img"
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key=>$image){
            // Mengambil isi atribut "src"
            $code = $image->getAttribute('src');

			// Mencari gambar yang bukan URL
            if(filter_var($code, FILTER_VALIDATE_URL) == false){
                // Upload foto
                list($type, $code) = explode(';', $code);
                list(, $code)      = explode(',', $code);
                $code = base64_decode($code);
                $mime = str_replace('data:', '', $type);
                $image_name = date('Y-m-d-H-i-s').' ('.($key+1).')';
                $image_name = $image_name.'.'.mime_to_ext($mime)[0];
                file_put_contents($path.$image_name, $code);

                // Mengganti atribut "src"
                $image->setAttribute('src', URL::to('/').'/'.$path.$image_name);
            }
        }
        
        // Return
        return $dom->saveHTML();
    }
}

// Menambah prefiks
if(!function_exists('add_prefix')){
    function add_prefix($string, $digit, $prefix){
        $add = '';
        if(strlen($string) < $digit){
            for($i=strlen($string); $i<$digit; $i++){
                $add .= $prefix;
            }
        }
        return $add.$string;
    }
}

// Mengganti nama permalink jika ada yang sama
if(!function_exists('rename_permalink')){
    function rename_permalink($permalink, $count){
        return $permalink."-".($count+1);
    }
}

// Mengacak string
if(!function_exists('shuffle_string')){
    function shuffle_string($length){
        $available_string = '1234567890QWERTYUIOPASDFGHJKLZXCVBNM';
        $string = substr(str_shuffle($available_string), 0, $length);
        return $string;
    }
}

/*--------------------------------------------------------------------------------------------*/
/* CONVERTERS */
/*--------------------------------------------------------------------------------------------*/

// Konversi Hex ke RGB
if(!function_exists('hex_to_rgb')){
    function hex_to_rgb($code){
        if($code[0] == '#')
            $code = substr($code, 1);

        if(strlen($code) == 3){
            $code = $code[0] . $code[0] . $code[1] . $code[1] . $code[2] . $code[2];
        }

        $r = hexdec($code[0] . $code[1]);
        $g = hexdec($code[2] . $code[3]);
        $b = hexdec($code[4] . $code[5]);

        return $b + ($g << 0x8) + ($r << 0x10);
    }
}

// Konversi RGB ke HSL
if(!function_exists('rgb_to_hsl')){
    function rgb_to_hsl($code){
        $r = 0xFF & ($code >> 0x10);
        $g = 0xFF & ($code >> 0x8);
        $b = 0xFF & $code;

        $r = ((float)$r) / 255.0;
        $g = ((float)$g) / 255.0;
        $b = ((float)$b) / 255.0;

        $maxC = max($r, $g, $b);
        $minC = min($r, $g, $b);

        $l = ($maxC + $minC) / 2.0;

        if($maxC == $minC){
        $s = 0;
        $h = 0;
        }
        else{
            if($l < .5){
                $s = ($maxC - $minC) / ($maxC + $minC);
            }
            else{
                $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
            }

            if($r == $maxC)
                $h = ($g - $b) / ($maxC - $minC);
            if($g == $maxC)
                $h = 2.0 + ($b - $r) / ($maxC - $minC);
            if($b == $maxC)
                $h = 4.0 + ($r - $g) / ($maxC - $minC);

            $h = $h / 6.0; 
        }

        $h = (int)round(255.0 * $h);
        $s = (int)round(255.0 * $s);
        $l = (int)round(255.0 * $l);

        return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
    }
}

// Konversi MIME menjadi ekstensi
if(!function_exists('mime_to_ext')){
    function mime_to_ext($mime){
        $mime_map = [
            'video/3gpp2'                                                               => ['3g2', 'file-video', 'Video'],
            'video/3gp'                                                                 => ['3gp', 'file-video', 'Video'],
            'video/3gpp'                                                                => ['3gp', 'file-video', 'Video'],
            'application/x-compressed'                                                  => ['7zip', 'file-archive', 'Arsip'],
            'audio/x-acc'                                                               => ['aac', 'file-audio', 'Audio'],
            'audio/ac3'                                                                 => ['ac3', 'file-audio', 'Audio'],
            'application/postscript'                                                    => ['ai', 'file-alt', 'Lainnya'],
            'audio/x-aiff'                                                              => ['aif', 'file-audio', 'Audio'],
            'audio/aiff'                                                                => ['aif', 'file-audio', 'Audio'],
            'audio/x-au'                                                                => ['au', 'file-audio', 'Audio'],
            'video/x-msvideo'                                                           => ['avi', 'file-video', 'Video'],
            'video/msvideo'                                                             => ['avi', 'file-video', 'Video'],
            'video/avi'                                                                 => ['avi', 'file-video', 'Video'],
            'application/x-troff-msvideo'                                               => ['avi', 'file-video', 'Video'],
            'application/macbinary'                                                     => ['bin', 'file-alt', 'Lainnya', 'Lainnya'],
            'application/mac-binary'                                                    => ['bin', 'file-alt', 'Lainnya'],
            'application/x-binary'                                                      => ['bin', 'file-alt', 'Lainnya'],
            'application/x-macbinary'                                                   => ['bin', 'file-alt', 'Lainnya'],
            'image/bmp'                                                                 => ['bmp', 'file-image', 'Gambar'],
            'image/x-bmp'                                                               => ['bmp', 'file-image', 'Gambar'],
            'image/x-bitmap'                                                            => ['bmp', 'file-image', 'Gambar'],
            'image/x-xbitmap'                                                           => ['bmp', 'file-image', 'Gambar'],
            'image/x-win-bitmap'                                                        => ['bmp', 'file-image', 'Gambar'],
            'image/x-windows-bmp'                                                       => ['bmp', 'file-image', 'Gambar'],
            'image/ms-bmp'                                                              => ['bmp', 'file-image', 'Gambar'],
            'image/x-ms-bmp'                                                            => ['bmp', 'file-image', 'Gambar'],
            'application/bmp'                                                           => ['bmp', 'file-alt', 'Lainnya'],
            'application/x-bmp'                                                         => ['bmp', 'file-alt', 'Lainnya'],
            'application/x-win-bitmap'                                                  => ['bmp', 'file-alt', 'Lainnya'],
            'application/cdr'                                                           => ['cdr', 'file-alt', 'Lainnya'],
            'application/coreldraw'                                                     => ['cdr', 'file-alt', 'Lainnya'],
            'application/x-cdr'                                                         => ['cdr', 'file-alt', 'Lainnya'],
            'application/x-coreldraw'                                                   => ['cdr', 'file-alt', 'Lainnya'],
            'image/cdr'                                                                 => ['cdr', 'file-image', 'Gambar'],
            'image/x-cdr'                                                               => ['cdr', 'file-image', 'Gambar'],
            'zz-application/zz-winassoc-cdr'                                            => ['cdr', 'file-alt', 'Lainnya'],
            'application/mac-compactpro'                                                => ['cpt', 'file-alt', 'Lainnya'],
            'application/pkix-crl'                                                      => ['crl', 'file-alt', 'Lainnya'],
            'application/pkcs-crl'                                                      => ['crl', 'file-alt', 'Lainnya'],
            'application/x-x509-ca-cert'                                                => ['crt', 'file-alt', 'Lainnya'],
            'application/pkix-cert'                                                     => ['crt', 'file-alt', 'Lainnya'],
            'text/css'                                                                  => ['css', 'file-code', 'Source Code'],
            'text/x-comma-separated-values'                                             => ['csv', 'file-excel', 'Spreadsheet'],
            'text/comma-separated-values'                                               => ['csv', 'file-excel', 'Spreadsheet'],
            'application/vnd.msexcel'                                                   => ['csv', 'file-excel', 'Spreadsheet'],
            'application/x-director'                                                    => ['dcr', 'file-alt', 'Lainnya'],
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => ['docx', 'file-word', 'Dokumen'],
            'application/x-dvi'                                                         => ['dvi', 'file-alt', 'Lainnya'],
            'message/rfc822'                                                            => ['eml', 'file-alt', 'Lainnya'],
            'application/x-msdownload'                                                  => ['exe', 'file-alt', 'Lainnya'],
            'video/x-f4v'                                                               => ['f4v', 'file-video', 'Video'],
            'audio/x-flac'                                                              => ['flac', 'file-audio', 'Audio'],
            'video/x-flv'                                                               => ['flv', 'file-video', 'Video'],
            'image/gif'                                                                 => ['gif', 'file-image', 'Gambar'],
            'application/gpg-keys'                                                      => ['gpg', 'file-alt', 'Lainnya'],
            'application/x-gtar'                                                        => ['gtar', 'file-archive', 'Arsip'],
            'application/x-gzip'                                                        => ['gzip', 'file-archive', 'Arsip'],
            'application/mac-binhex40'                                                  => ['hqx', 'file-alt', 'Lainnya'],
            'application/mac-binhex'                                                    => ['hqx', 'file-alt', 'Lainnya'],
            'application/x-binhex40'                                                    => ['hqx', 'file-alt', 'Lainnya'],
            'application/x-mac-binhex40'                                                => ['hqx', 'file-alt', 'Lainnya'],
            'text/html'                                                                 => ['html', 'file-code', 'Source Code'],
            'image/x-icon'                                                              => ['ico', 'file-image', 'Gambar'],
            'image/x-ico'                                                               => ['ico', 'file-image', 'Gambar'],
            'image/vnd.microsoft.icon'                                                  => ['ico', 'file-image', 'Gambar'],
            'text/calendar'                                                             => ['ics', 'file-alt', 'Lainnya'],
            'application/java-archive'                                                  => ['jar', 'file-alt', 'Lainnya'],
            'application/x-java-application'                                            => ['jar', 'file-alt', 'Lainnya'],
            'application/x-jar'                                                         => ['jar', 'file-alt', 'Lainnya'],
            'image/jp2'                                                                 => ['jp2', 'file-image', 'Gambar'],
            'video/mj2'                                                                 => ['jp2', 'file-video', 'Video'],
            'image/jpx'                                                                 => ['jp2', 'file-image', 'Gambar'],
            'image/jpm'                                                                 => ['jp2', 'file-image', 'Gambar'],
            'image/jpeg'                                                                => ['jpeg', 'file-image', 'Gambar'],
            'image/pjpeg'                                                               => ['jpeg', 'file-image', 'Gambar'],
            'application/x-javascript'                                                  => ['js', 'file-code', 'Source Code'],
            'application/json'                                                          => ['json', 'file-alt', 'Lainnya'],
            'text/json'                                                                 => ['json', 'file-alt', 'Lainnya'],
            'application/vnd.google-earth.kml+xml'                                      => ['kml', 'file-alt', 'Lainnya'],
            'application/vnd.google-earth.kmz'                                          => ['kmz', 'file-alt', 'Lainnya'],
            'text/x-log'                                                                => ['log', 'file-alt', 'Lainnya'],
            'audio/x-m4a'                                                               => ['m4a', 'file-audio', 'Audio'],
            'audio/mp4'                                                                 => ['m4a', 'file-audio', 'Audio'],
            'application/vnd.mpegurl'                                                   => ['m4u', 'file-alt', 'Lainnya'],
            'audio/midi'                                                                => ['mid', 'file-audio', 'Audio'],
            'application/vnd.mif'                                                       => ['mif', 'file-alt', 'Lainnya'],
            'video/quicktime'                                                           => ['mov', 'file-video', 'Video'],
            'video/x-sgi-movie'                                                         => ['movie', 'file-video', 'Video'],
            'audio/mpeg'                                                                => ['mp3', 'file-audio', 'Audio'],
            'audio/mpg'                                                                 => ['mp3', 'file-audio', 'Audio'],
            'audio/mpeg3'                                                               => ['mp3', 'file-audio', 'Audio'],
            'audio/mp3'                                                                 => ['mp3', 'file-audio', 'Audio'],
            'video/mp4'                                                                 => ['mp4', 'file-video', 'Video'],
            'video/mpeg'                                                                => ['mpeg', 'file-video', 'Video'],
            'application/oda'                                                           => ['oda', 'file-alt', 'Lainnya'],
            'audio/ogg'                                                                 => ['ogg', 'file-audio', 'Audio'],
            'video/ogg'                                                                 => ['ogg', 'file-video', 'Video'],
            'application/ogg'                                                           => ['ogg', 'file-alt', 'Lainnya'],
            'application/x-pkcs10'                                                      => ['p10', 'file-alt', 'Lainnya'],
            'application/pkcs10'                                                        => ['p10', 'file-alt', 'Lainnya'],
            'application/x-pkcs12'                                                      => ['p12', 'file-alt', 'Lainnya'],
            'application/x-pkcs7-signature'                                             => ['p7a', 'file-alt', 'Lainnya'],
            'application/pkcs7-mime'                                                    => ['p7c', 'file-alt', 'Lainnya'],
            'application/x-pkcs7-mime'                                                  => ['p7c', 'file-alt', 'Lainnya'],
            'application/x-pkcs7-certreqresp'                                           => ['p7r', 'file-alt', 'Lainnya'],
            'application/pkcs7-signature'                                               => ['p7s', 'file-alt', 'Lainnya'],
            'application/pdf'                                                           => ['pdf', 'file-pdf', 'PDF'],
            'application/x-x509-user-cert'                                              => ['pem', 'file-alt', 'Lainnya'],
            'application/x-pem-file'                                                    => ['pem', 'file-alt', 'Lainnya'],
            'application/pgp'                                                           => ['pgp', 'file-alt', 'Lainnya'],
            'application/x-httpd-php'                                                   => ['php', 'file-code', 'Source Code'],
            'application/php'                                                           => ['php', 'file-code', 'Source Code'],
            'application/x-php'                                                         => ['php', 'file-code', 'Source Code'],
            'text/php'                                                                  => ['php', 'file-code', 'Source Code'],
            'text/x-php'                                                                => ['php', 'file-code', 'Source Code'],
            'application/x-httpd-php-source'                                            => ['php', 'file-code', 'Source Code'],
            'image/png'                                                                 => ['png', 'file-image', 'Gambar'],
            'image/x-png'                                                               => ['png', 'file-image', 'Gambar'],
            'application/powerpoint'                                                    => ['ppt', 'file-powerpoint', 'Power Point'],
            'application/vnd.ms-powerpoint'                                             => ['ppt', 'file-powerpoint', 'Power Point'],
            'application/vnd.ms-office'                                                 => ['ppt', 'file-powerpoint', 'Power Point'],
            'application/msword'                                                        => ['ppt', 'file-powerpoint', 'Power Point'],
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => ['pptx', 'file-powerpoint', 'Power Point'],
            'application/x-photoshop'                                                   => ['psd', 'file-alt', 'Lainnya'],
            'image/vnd.adobe.photoshop'                                                 => ['psd', 'file-alt', 'Lainnya'],
            'audio/x-realaudio'                                                         => ['ra', 'file-audio', 'Audio'],
            'audio/x-pn-realaudio'                                                      => ['ram', 'file-audio', 'Audio'],
            'application/x-rar'                                                         => ['rar', 'file-archive', 'Arsip'],
            'application/rar'                                                           => ['rar', 'file-archive', 'Arsip'],
            'application/x-rar-compressed'                                              => ['rar', 'file-archive', 'Arsip'],
            'application/octet-stream'                                                  => ['rar', 'file-archive', 'Arsip'],
            'audio/x-pn-realaudio-plugin'                                               => ['rpm', 'file-alt', 'Lainnya'],
            'application/x-pkcs7'                                                       => ['rsa', 'file-alt', 'Lainnya'],
            'text/rtf'                                                                  => ['rtf', 'file-alt', 'Lainnya'],
            'text/richtext'                                                             => ['rtx', 'file-alt', 'Lainnya'],
            'video/vnd.rn-realvideo'                                                    => ['rv', 'file-video', 'Video'],
            'application/x-stuffit'                                                     => ['sit', 'file-alt', 'Lainnya'],
            'application/smil'                                                          => ['smil', 'file-alt', 'Lainnya'],
            'text/srt'                                                                  => ['srt', 'file-alt', 'Lainnya'],
            'image/svg+xml'                                                             => ['svg', 'file-image', 'Gambar'],
            'application/x-shockwave-flash'                                             => ['swf', 'file-alt', 'Lainnya'],
            'application/x-tar'                                                         => ['tar', 'file-archive', 'Arsip'],
            'application/x-gzip-compressed'                                             => ['tgz', 'file-archive', 'Arsip'],
            'image/tiff'                                                                => ['tiff', 'file-alt', 'Lainnya'],
            'text/plain'                                                                => ['txt', 'file-alt', 'Lainnya'],
            'text/x-vcard'                                                              => ['vcf', 'file-alt', 'Lainnya'],
            'application/videolan'                                                      => ['vlc', 'file-alt', 'Lainnya'],
            'text/vtt'                                                                  => ['vtt', 'file-alt', 'Lainnya'],
            'audio/x-wav'                                                               => ['wav', 'file-audio', 'Audio'],
            'audio/wave'                                                                => ['wav', 'file-audio', 'Audio'],
            'audio/wav'                                                                 => ['wav', 'file-audio', 'Audio'],
            'application/wbxml'                                                         => ['wbxml', 'file-alt', 'Lainnya'],
            'video/webm'                                                                => ['webm', 'file-video', 'Video'],
            'image/webp'                                                                => ['webp', 'file-image', 'Gambar'],
            'audio/x-ms-wma'                                                            => ['wma', 'file-audio', 'Audio'],
            'application/wmlc'                                                          => ['wmlc', 'file-alt', 'Lainnya'],
            'video/x-ms-wmv'                                                            => ['wmv', 'file-video', 'Video'],
            'video/x-ms-asf'                                                            => ['wmv', 'file-video', 'Video'],
            'application/xhtml+xml'                                                     => ['xhtml', 'file-code', 'Source Code'],
            'application/excel'                                                         => ['xl', 'file-excel', 'Spreadsheet'],
            'application/msexcel'                                                       => ['xls', 'file-excel', 'Spreadsheet'],
            'application/x-msexcel'                                                     => ['xls', 'file-excel', 'Spreadsheet'],
            'application/x-ms-excel'                                                    => ['xls', 'file-excel', 'Spreadsheet'],
            'application/x-excel'                                                       => ['xls', 'file-excel', 'Spreadsheet'],
            'application/x-dos_ms_excel'                                                => ['xls', 'file-excel', 'Spreadsheet'],
            'application/xls'                                                           => ['xls', 'file-excel', 'Spreadsheet'],
            'application/x-xls'                                                         => ['xls', 'file-excel', 'Spreadsheet'],
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => ['xlsx', 'file-excel', 'Spreadsheet'],
            'application/vnd.ms-excel'                                                  => ['xlsx', 'file-excel', 'Spreadsheet'],
            'application/xml'                                                           => ['xml', 'file-alt', 'Lainnya'],
            'text/xml'                                                                  => ['xml', 'file-alt', 'Lainnya'],
            'text/xsl'                                                                  => ['xsl', 'file-alt', 'Lainnya'],
            'application/xspf+xml'                                                      => ['xspf', 'file-alt', 'Lainnya'],
            'application/x-compress'                                                    => ['z', 'file-archive', 'Arsip'],
            'application/x-zip'                                                         => ['zip', 'file-archive', 'Arsip'],
            'application/zip'                                                           => ['zip', 'file-archive', 'Arsip'],
            'application/x-zip-compressed'                                              => ['zip', 'file-archive', 'Arsip'],
            'application/s-compressed'                                                  => ['zip', 'file-archive', 'Arsip'],
            'multipart/x-zip'                                                           => ['zip', 'file-archive', 'Arsip'],
            'text/x-scriptzsh'                                                          => ['zsh', 'file-alt', 'Lainnya'],
        ];

        return isset($mime_map[$mime]) ? $mime_map[$mime] : false;
    }
}

/*--------------------------------------------------------------------------------------------*/
/* JSON */
/*--------------------------------------------------------------------------------------------*/

// JSON Tag
if(!function_exists('json_tag')){
    function json_tag(){
        $array = [];
        $tag = DB::table('tag')->orderBy('tag','asc')->get();
        if(count($tag) > 0){
            foreach($tag as $data){
                array_push($array, $data->tag);
            }
        }

        return json_encode($array);
    }
}

// JSON Font Awesome 5.0.9
if(!function_exists('json_fa')){
    function json_fa(){
        return [
            "fas fa-address-book","fas fa-address-card","fas fa-adjust","fas fa-align-center","fas fa-align-justify","fas fa-align-left","fas fa-align-right","fas fa-allergies","fas fa-ambulance","fas fa-american-sign-language-interpreting","fas fa-anchor","fas fa-angle-double-down","fas fa-angle-double-left","fas fa-angle-double-right","fas fa-angle-double-up","fas fa-angle-down","fas fa-angle-left","fas fa-angle-right","fas fa-angle-up","fas fa-archive","fas fa-arrow-alt-circle-down","fas fa-arrow-alt-circle-left","fas fa-arrow-alt-circle-right","fas fa-arrow-alt-circle-up","fas fa-arrow-circle-down","fas fa-arrow-circle-left","fas fa-arrow-circle-right","fas fa-arrow-circle-up","fas fa-arrow-down","fas fa-arrow-left","fas fa-arrow-right","fas fa-arrow-up","fas fa-arrows-alt","fas fa-arrows-alt-h","fas fa-arrows-alt-v","fas fa-assistive-listening-systems","fas fa-asterisk","fas fa-at","fas fa-audio-description","fas fa-backward","fas fa-balance-scale","fas fa-ban","fas fa-band-aid","fas fa-barcode","fas fa-bars","fas fa-baseball-ball","fas fa-basketball-ball","fas fa-bath","fas fa-battery-empty","fas fa-battery-full","fas fa-battery-half","fas fa-battery-quarter","fas fa-battery-three-quarters","fas fa-bed","fas fa-beer","fas fa-bell","fas fa-bell-slash","fas fa-bicycle","fas fa-binoculars","fas fa-birthday-cake","fas fa-blind","fas fa-bold","fas fa-bolt","fas fa-bomb","fas fa-book","fas fa-bookmark","fas fa-bowling-ball","fas fa-box","fas fa-box-open","fas fa-boxes","fas fa-braille","fas fa-briefcase","fas fa-briefcase-medical","fas fa-bug","fas fa-building","fas fa-bullhorn","fas fa-bullseye","fas fa-burn","fas fa-bus","fas fa-calculator","fas fa-calendar","fas fa-calendar-alt","fas fa-calendar-check","fas fa-calendar-minus","fas fa-calendar-plus","fas fa-calendar-times","fas fa-camera","fas fa-camera-retro","fas fa-capsules","fas fa-car","fas fa-caret-down","fas fa-caret-left","fas fa-caret-right","fas fa-caret-square-down","fas fa-caret-square-left","fas fa-caret-square-right","fas fa-caret-square-up","fas fa-caret-up","fas fa-cart-arrow-down","fas fa-cart-plus","fas fa-certificate","fas fa-chart-area","fas fa-chart-bar","fas fa-chart-line","fas fa-chart-pie","fas fa-check","fas fa-check-circle","fas fa-check-square","fas fa-chess","fas fa-chess-bishop","fas fa-chess-board","fas fa-chess-king","fas fa-chess-knight","fas fa-chess-pawn","fas fa-chess-queen","fas fa-chess-rook","fas fa-chevron-circle-down","fas fa-chevron-circle-left","fas fa-chevron-circle-right","fas fa-chevron-circle-up","fas fa-chevron-down","fas fa-chevron-left","fas fa-chevron-right","fas fa-chevron-up","fas fa-child","fas fa-circle","fas fa-circle-notch","fas fa-clipboard","fas fa-clipboard-check","fas fa-clipboard-list","fas fa-clock","fas fa-clone","fas fa-closed-captioning","fas fa-cloud","fas fa-cloud-download-alt","fas fa-cloud-upload-alt","fas fa-code","fas fa-code-branch","fas fa-coffee","fas fa-cog","fas fa-cogs","fas fa-columns","fas fa-comment","fas fa-comment-alt","fas fa-comment-dots","fas fa-comment-slash","fas fa-comments","fas fa-compass","fas fa-compress","fas fa-copy","fas fa-copyright","fas fa-couch","fas fa-credit-card","fas fa-crop","fas fa-crosshairs","fas fa-cube","fas fa-cubes","fas fa-cut","fas fa-database","fas fa-deaf","fas fa-desktop","fas fa-diagnoses","fas fa-dna","fas fa-dollar-sign","fas fa-dolly","fas fa-dolly-flatbed","fas fa-donate","fas fa-dot-circle","fas fa-dove","fas fa-download","fas fa-edit","fas fa-eject","fas fa-ellipsis-h","fas fa-ellipsis-v","fas fa-envelope","fas fa-envelope-open","fas fa-envelope-square","fas fa-eraser","fas fa-euro-sign","fas fa-exchange-alt","fas fa-exclamation","fas fa-exclamation-circle","fas fa-exclamation-triangle","fas fa-expand","fas fa-expand-arrows-alt","fas fa-external-link-alt","fas fa-external-link-square-alt","fas fa-eye","fas fa-eye-dropper","fas fa-eye-slash","fas fa-fast-backward","fas fa-fast-forward","fas fa-fax","fas fa-female","fas fa-fighter-jet","fas fa-file","fas fa-file-alt","fas fa-file-archive","fas fa-file-audio","fas fa-file-code","fas fa-file-excel","fas fa-file-image","fas fa-file-medical","fas fa-file-medical-alt","fas fa-file-pdf","fas fa-file-powerpoint","fas fa-file-video","fas fa-file-word","fas fa-film","fas fa-filter","fas fa-fire","fas fa-fire-extinguisher","fas fa-first-aid","fas fa-flag","fas fa-flag-checkered","fas fa-flask","fas fa-folder","fas fa-folder-open","fas fa-font","fas fa-football-ball","fas fa-forward","fas fa-frown","fas fa-futbol","fas fa-gamepad","fas fa-gavel","fas fa-gem","fas fa-genderless","fas fa-gift","fas fa-glass-martini","fas fa-globe","fas fa-golf-ball","fas fa-graduation-cap","fas fa-h-square","fas fa-hand-holding","fas fa-hand-holding-heart","fas fa-hand-holding-usd","fas fa-hand-lizard","fas fa-hand-paper","fas fa-hand-peace","fas fa-hand-point-down","fas fa-hand-point-left","fas fa-hand-point-right","fas fa-hand-point-up","fas fa-hand-pointer","fas fa-hand-rock","fas fa-hand-scissors","fas fa-hand-spock","fas fa-hands","fas fa-hands-helping","fas fa-handshake","fas fa-hashtag","fas fa-hdd","fas fa-heading","fas fa-headphones","fas fa-heart","fas fa-heartbeat","fas fa-history","fas fa-hockey-puck","fas fa-home","fas fa-hospital","fas fa-hospital-alt","fas fa-hospital-symbol","fas fa-hourglass","fas fa-hourglass-end","fas fa-hourglass-half","fas fa-hourglass-start","fas fa-i-cursor","fas fa-id-badge","fas fa-id-card","fas fa-id-card-alt","fas fa-image","fas fa-images","fas fa-inbox","fas fa-indent","fas fa-industry","fas fa-info","fas fa-info-circle","fas fa-italic","fas fa-key","fas fa-keyboard","fas fa-language","fas fa-laptop","fas fa-leaf","fas fa-lemon","fas fa-level-down-alt","fas fa-level-up-alt","fas fa-life-ring","fas fa-lightbulb","fas fa-link","fas fa-lira-sign","fas fa-list","fas fa-list-alt","fas fa-list-ol","fas fa-list-ul","fas fa-location-arrow","fas fa-lock","fas fa-lock-open","fas fa-long-arrow-alt-down","fas fa-long-arrow-alt-left","fas fa-long-arrow-alt-right","fas fa-long-arrow-alt-up","fas fa-low-vision","fas fa-magic","fas fa-magnet","fas fa-male","fas fa-map","fas fa-map-marker","fas fa-map-marker-alt","fas fa-map-pin","fas fa-map-signs","fas fa-mars","fas fa-mars-double","fas fa-mars-stroke","fas fa-mars-stroke-h","fas fa-mars-stroke-v","fas fa-medkit","fas fa-meh","fas fa-mercury","fas fa-microchip","fas fa-microphone","fas fa-microphone-slash","fas fa-minus","fas fa-minus-circle","fas fa-minus-square","fas fa-mobile","fas fa-mobile-alt","fas fa-money-bill-alt","fas fa-moon","fas fa-motorcycle","fas fa-mouse-pointer","fas fa-music","fas fa-neuter","fas fa-newspaper","fas fa-notes-medical","fas fa-object-group","fas fa-object-ungroup","fas fa-outdent","fas fa-paint-brush","fas fa-pallet","fas fa-paper-plane","fas fa-paperclip","fas fa-parachute-box","fas fa-paragraph","fas fa-paste","fas fa-pause","fas fa-pause-circle","fas fa-paw","fas fa-pen-square","fas fa-pencil-alt","fas fa-people-carry","fas fa-percent","fas fa-phone","fas fa-phone-slash","fas fa-phone-square","fas fa-phone-volume","fas fa-piggy-bank","fas fa-pills","fas fa-plane","fas fa-play","fas fa-play-circle","fas fa-plug","fas fa-plus","fas fa-plus-circle","fas fa-plus-square","fas fa-podcast","fas fa-poo","fas fa-pound-sign","fas fa-power-off","fas fa-prescription-bottle","fas fa-prescription-bottle-alt","fas fa-print","fas fa-procedures","fas fa-puzzle-piece","fas fa-qrcode","fas fa-question","fas fa-question-circle","fas fa-quidditch","fas fa-quote-left","fas fa-quote-right","fas fa-random","fas fa-recycle","fas fa-redo","fas fa-redo-alt","fas fa-registered","fas fa-reply","fas fa-reply-all","fas fa-retweet","fas fa-ribbon","fas fa-road","fas fa-rocket","fas fa-rss","fas fa-rss-square","fas fa-ruble-sign","fas fa-rupee-sign","fas fa-save","fas fa-search","fas fa-search-minus","fas fa-search-plus","fas fa-seedling","fas fa-server","fas fa-share","fas fa-share-alt","fas fa-share-alt-square","fas fa-share-square","fas fa-shekel-sign","fas fa-shield-alt","fas fa-ship","fas fa-shipping-fast","fas fa-shopping-bag","fas fa-shopping-basket","fas fa-shopping-cart","fas fa-shower","fas fa-sign","fas fa-sign-in-alt","fas fa-sign-language","fas fa-sign-out-alt","fas fa-signal","fas fa-sitemap","fas fa-sliders-h","fas fa-smile","fas fa-smoking","fas fa-snowflake","fas fa-sort","fas fa-sort-alpha-down","fas fa-sort-alpha-up","fas fa-sort-amount-down","fas fa-sort-amount-up","fas fa-sort-down","fas fa-sort-numeric-down","fas fa-sort-numeric-up","fas fa-sort-up","fas fa-space-shuttle","fas fa-spinner","fas fa-square","fas fa-square-full","fas fa-star","fas fa-star-half","fas fa-step-backward","fas fa-step-forward","fas fa-stethoscope","fas fa-sticky-note","fas fa-stop","fas fa-stop-circle","fas fa-stopwatch","fas fa-street-view","fas fa-strikethrough","fas fa-subscript","fas fa-subway","fas fa-suitcase","fas fa-sun","fas fa-superscript","fas fa-sync","fas fa-sync-alt","fas fa-syringe","fas fa-table","fas fa-table-tennis","fas fa-tablet","fas fa-tablet-alt","fas fa-tablets","fas fa-tachometer-alt","fas fa-tag","fas fa-tags","fas fa-tape","fas fa-tasks","fas fa-taxi","fas fa-terminal","fas fa-text-height","fas fa-text-width","fas fa-th","fas fa-th-large","fas fa-th-list","fas fa-thermometer","fas fa-thermometer-empty","fas fa-thermometer-full","fas fa-thermometer-half","fas fa-thermometer-quarter","fas fa-thermometer-three-quarters","fas fa-thumbs-down","fas fa-thumbs-up","fas fa-thumbtack","fas fa-ticket-alt","fas fa-times","fas fa-times-circle","fas fa-tint","fas fa-toggle-off","fas fa-toggle-on","fas fa-trademark","fas fa-train","fas fa-transgender","fas fa-transgender-alt","fas fa-trash","fas fa-trash-alt","fas fa-tree","fas fa-trophy","fas fa-truck","fas fa-truck-loading","fas fa-truck-moving","fas fa-tty","fas fa-tv","fas fa-umbrella","fas fa-underline","fas fa-undo","fas fa-undo-alt","fas fa-universal-access","fas fa-university","fas fa-unlink","fas fa-unlock","fas fa-unlock-alt","fas fa-upload","fas fa-user","fas fa-user-circle","fas fa-user-md","fas fa-user-plus","fas fa-user-secret","fas fa-user-times","fas fa-users","fas fa-utensil-spoon","fas fa-utensils","fas fa-venus","fas fa-venus-double","fas fa-venus-mars","fas fa-vial","fas fa-vials","fas fa-video","fas fa-video-slash","fas fa-volleyball-ball","fas fa-volume-down","fas fa-volume-off","fas fa-volume-up","fas fa-warehouse","fas fa-weight","fas fa-wheelchair","fas fa-wifi","fas fa-window-close","fas fa-window-maximize","fas fa-window-minimize","fas fa-window-restore","fas fa-wine-glass","fas fa-won-sign","fas fa-wrench","fas fa-x-ray","fas fa-yen-sign","far fa-address-book","far fa-address-card","far fa-arrow-alt-circle-down","far fa-arrow-alt-circle-left","far fa-arrow-alt-circle-right","far fa-arrow-alt-circle-up","far fa-bell","far fa-bell-slash","far fa-bookmark","far fa-building","far fa-calendar","far fa-calendar-alt","far fa-calendar-check","far fa-calendar-minus","far fa-calendar-plus","far fa-calendar-times","far fa-caret-square-down","far fa-caret-square-left","far fa-caret-square-right","far fa-caret-square-up","far fa-chart-bar","far fa-check-circle","far fa-check-square","far fa-circle","far fa-clipboard","far fa-clock","far fa-clone","far fa-closed-captioning","far fa-comment","far fa-comment-alt","far fa-comments","far fa-compass","far fa-copy","far fa-copyright","far fa-credit-card","far fa-dot-circle","far fa-edit","far fa-envelope","far fa-envelope-open","far fa-eye-slash","far fa-file","far fa-file-alt","far fa-file-archive","far fa-file-audio","far fa-file-code","far fa-file-excel","far fa-file-image","far fa-file-pdf","far fa-file-powerpoint","far fa-file-video","far fa-file-word","far fa-flag","far fa-folder","far fa-folder-open","far fa-frown","far fa-futbol","far fa-gem","far fa-hand-lizard","far fa-hand-paper","far fa-hand-peace","far fa-hand-point-down","far fa-hand-point-left","far fa-hand-point-right","far fa-hand-point-up","far fa-hand-pointer","far fa-hand-rock","far fa-hand-scissors","far fa-hand-spock","far fa-handshake","far fa-hdd","far fa-heart","far fa-hospital","far fa-hourglass","far fa-id-badge","far fa-id-card","far fa-image","far fa-images","far fa-keyboard","far fa-lemon","far fa-life-ring","far fa-lightbulb","far fa-list-alt","far fa-map","far fa-meh","far fa-minus-square","far fa-money-bill-alt","far fa-moon","far fa-newspaper","far fa-object-group","far fa-object-ungroup","far fa-paper-plane","far fa-pause-circle","far fa-play-circle","far fa-plus-square","far fa-question-circle","far fa-registered","far fa-save","far fa-share-square","far fa-smile","far fa-snowflake","far fa-square","far fa-star","far fa-star-half","far fa-sticky-note","far fa-stop-circle","far fa-sun","far fa-thumbs-down","far fa-thumbs-up","far fa-times-circle","far fa-trash-alt","far fa-user","far fa-user-circle","far fa-window-close","far fa-window-maximize","far fa-window-minimize","far fa-window-restore","fab fa-500px","fab fa-accessible-icon","fab fa-accusoft","fab fa-adn","fab fa-adversal","fab fa-affiliatetheme","fab fa-algolia","fab fa-amazon","fab fa-amazon-pay","fab fa-amilia","fab fa-android","fab fa-angellist","fab fa-angrycreative","fab fa-angular","fab fa-app-store","fab fa-app-store-ios","fab fa-apper","fab fa-apple","fab fa-apple-pay","fab fa-asymmetrik","fab fa-audible","fab fa-autoprefixer","fab fa-avianex","fab fa-aviato","fab fa-aws","fab fa-bandcamp","fab fa-behance","fab fa-behance-square","fab fa-bimobject","fab fa-bitbucket","fab fa-bitcoin","fab fa-bity","fab fa-black-tie","fab fa-blackberry","fab fa-blogger","fab fa-blogger-b","fab fa-bluetooth","fab fa-bluetooth-b","fab fa-btc","fab fa-buromobelexperte","fab fa-buysellads","fab fa-cc-amazon-pay","fab fa-cc-amex","fab fa-cc-apple-pay","fab fa-cc-diners-club","fab fa-cc-discover","fab fa-cc-jcb","fab fa-cc-mastercard","fab fa-cc-paypal","fab fa-cc-stripe","fab fa-cc-visa","fab fa-centercode","fab fa-chrome","fab fa-cloudscale","fab fa-cloudsmith","fab fa-cloudversify","fab fa-codepen","fab fa-codiepie","fab fa-connectdevelop","fab fa-contao","fab fa-cpanel","fab fa-creative-commons","fab fa-css3","fab fa-css3-alt","fab fa-cuttlefish","fab fa-d-and-d","fab fa-dashcube","fab fa-delicious","fab fa-deploydog","fab fa-deskpro","fab fa-deviantart","fab fa-digg","fab fa-digital-ocean","fab fa-discord","fab fa-discourse","fab fa-dochub","fab fa-docker","fab fa-draft2digital","fab fa-dribbble","fab fa-dribbble-square","fab fa-dropbox","fab fa-drupal","fab fa-dyalog","fab fa-earlybirds","fab fa-edge","fab fa-elementor","fab fa-ember","fab fa-empire","fab fa-envira","fab fa-erlang","fab fa-ethereum","fab fa-etsy","fab fa-expeditedssl","fab fa-facebook","fab fa-facebook-f","fab fa-facebook-messenger","fab fa-facebook-square","fab fa-firefox","fab fa-first-order","fab fa-firstdraft","fab fa-flickr","fab fa-flipboard","fab fa-fly","fab fa-font-awesome","fab fa-font-awesome-alt","fab fa-font-awesome-flag","fab fa-fonticons","fab fa-fonticons-fi","fab fa-fort-awesome","fab fa-fort-awesome-alt","fab fa-forumbee","fab fa-foursquare","fab fa-free-code-camp","fab fa-freebsd","fab fa-get-pocket","fab fa-gg","fab fa-gg-circle","fab fa-git","fab fa-git-square","fab fa-github","fab fa-github-alt","fab fa-github-square","fab fa-gitkraken","fab fa-gitlab","fab fa-gitter","fab fa-glide","fab fa-glide-g","fab fa-gofore","fab fa-goodreads","fab fa-goodreads-g","fab fa-google","fab fa-google-drive","fab fa-google-play","fab fa-google-plus","fab fa-google-plus-g","fab fa-google-plus-square","fab fa-google-wallet","fab fa-gratipay","fab fa-grav","fab fa-gripfire","fab fa-grunt","fab fa-gulp","fab fa-hacker-news","fab fa-hacker-news-square","fab fa-hips","fab fa-hire-a-helper","fab fa-hooli","fab fa-hotjar","fab fa-houzz","fab fa-html5","fab fa-hubspot","fab fa-imdb","fab fa-instagram","fab fa-internet-explorer","fab fa-ioxhost","fab fa-itunes","fab fa-itunes-note","fab fa-jenkins","fab fa-joget","fab fa-joomla","fab fa-js","fab fa-js-square","fab fa-jsfiddle","fab fa-keycdn","fab fa-kickstarter","fab fa-kickstarter-k","fab fa-korvue","fab fa-laravel","fab fa-lastfm","fab fa-lastfm-square","fab fa-leanpub","fab fa-less","fab fa-line","fab fa-linkedin","fab fa-linkedin-in","fab fa-linode","fab fa-linux","fab fa-lyft","fab fa-magento","fab fa-maxcdn","fab fa-medapps","fab fa-medium","fab fa-medium-m","fab fa-medrt","fab fa-meetup","fab fa-microsoft","fab fa-mix","fab fa-mixcloud","fab fa-mizuni","fab fa-modx","fab fa-monero","fab fa-napster","fab fa-nintendo-switch","fab fa-node","fab fa-node-js","fab fa-npm","fab fa-ns8","fab fa-nutritionix","fab fa-odnoklassniki","fab fa-odnoklassniki-square","fab fa-opencart","fab fa-openid","fab fa-opera","fab fa-optin-monster","fab fa-osi","fab fa-page4","fab fa-pagelines","fab fa-palfed","fab fa-patreon","fab fa-paypal","fab fa-periscope","fab fa-phabricator","fab fa-phoenix-framework","fab fa-php","fab fa-pied-piper","fab fa-pied-piper-alt","fab fa-pied-piper-pp","fab fa-pinterest","fab fa-pinterest-p","fab fa-pinterest-square","fab fa-playstation","fab fa-product-hunt","fab fa-pushed","fab fa-python","fab fa-qq","fab fa-quinscape","fab fa-quora","fab fa-ravelry","fab fa-react","fab fa-readme","fab fa-rebel","fab fa-red-river","fab fa-reddit","fab fa-reddit-alien","fab fa-reddit-square","fab fa-rendact","fab fa-renren","fab fa-replyd","fab fa-resolving","fab fa-rocketchat","fab fa-rockrms","fab fa-safari","fab fa-sass","fab fa-schlix","fab fa-scribd","fab fa-searchengin","fab fa-sellcast","fab fa-sellsy","fab fa-servicestack","fab fa-shirtsinbulk","fab fa-simplybuilt","fab fa-sistrix","fab fa-skyatlas","fab fa-skype","fab fa-slack","fab fa-slack-hash","fab fa-slideshare","fab fa-snapchat","fab fa-snapchat-ghost","fab fa-snapchat-square","fab fa-soundcloud","fab fa-speakap","fab fa-spotify","fab fa-stack-exchange","fab fa-stack-overflow","fab fa-staylinked","fab fa-steam","fab fa-steam-square","fab fa-steam-symbol","fab fa-sticker-mule","fab fa-strava","fab fa-stripe","fab fa-stripe-s","fab fa-studiovinari","fab fa-stumbleupon","fab fa-stumbleupon-circle","fab fa-superpowers","fab fa-supple","fab fa-telegram","fab fa-telegram-plane","fab fa-tencent-weibo","fab fa-themeisle","fab fa-trello","fab fa-tripadvisor","fab fa-tumblr","fab fa-tumblr-square","fab fa-twitch","fab fa-twitter","fab fa-twitter-square","fab fa-typo3","fab fa-uber","fab fa-uikit","fab fa-uniregistry","fab fa-untappd","fab fa-usb","fab fa-ussunnah","fab fa-vaadin","fab fa-viacoin","fab fa-viadeo","fab fa-viadeo-square","fab fa-viber","fab fa-vimeo","fab fa-vimeo-square","fab fa-vimeo-v","fab fa-vine","fab fa-vk","fab fa-vnv","fab fa-vuejs","fab fa-weibo","fab fa-weixin","fab fa-whatsapp","fab fa-whatsapp-square","fab fa-whmcs","fab fa-wikipedia-w","fab fa-windows","fab fa-wordpress","fab fa-wordpress-simple","fab fa-wpbeginner","fab fa-wpexplorer","fab fa-wpforms","fab fa-xbox","fab fa-xing","fab fa-xing-square","fab fa-y-combinator","fab fa-yahoo","fab fa-yandex","fab fa-yandex-international","fab fa-yelp","fab fa-yoast","fab fa-youtube","fab fa-youtube-square",
        ];
    }
}