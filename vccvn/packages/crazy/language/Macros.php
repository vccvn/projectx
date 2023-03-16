<?php

namespace App\Support;


/**
 * Class Macros
 * @package App\Services
 */
class Macros
{
    protected static $positions = [
        1 =>'21.040165,105.827951',
        2 =>'10.800526,106.660833',
        3 =>'10.382875,105.439001',
        4 =>'9.293931,105.721551',
        5 =>'10.502052,107.192680',
        6 =>'22.148525,105.836260',
        7 =>'21.276219,106.206035',
        8 =>'21.178026,106.058963',
        9 =>'10.240630,106.375953',
        10=>'10.947011,106.742157',
        11=>'13.776822,109.226466',
        12=>'11.537651,106.901812',
        13=>'10.938268,108.103597',
        14=>'22.666276,106.260913',
        15=>'9.177204,105.154270',
        16=>'10.043633,105.765165',
        17=>'16.061050,108.222094',
        18=>'12.673395,108.042712',
        19=>'12.003740,107.687367',
        20=>'21.391183,103.031440',
        21=>'10.971338,106.891153',
        22=>'10.304083,105.757098',
        23=>'13.972019,108.013159',
        24=>'22.819202,104.984550',
        25=>'20.544391,105.920324',
        26=>'21.140050,105.502584',
        27=>'18.341787,105.902846',
        28=>'20.939788,106.330785',
        29=>'20.852190,106.685840',
        30=>'9.812919,105.818486',
        31=>'20.827852,105.339106',
        32=>'20.847423,106.011336',
        33=>'12.247012,109.189413',
        34=>'10.019999,105.087847',
        35=>'14.355122,108.007048',
        36=>'22.400404,103.447961',
        37=>'21.854038,106.765608',
        38=>'22.445440,104.004290',
        39=>'11.941962,108.453481',
        40=>'10.811968,106.474866',
        41=>'20.420253,106.168246',
        42=>'18.686653,105.681222',
        43=>'20.250992,105.974477',
        44=>'1.577945,108.993662',
        45=>'21.333730,105.374607',
        46=>'13.111960,109.300529',
        47=>'17.471086,106.622160',
        48=>'15.583887,108.468475',
        49=>'15.123219,108.803760',
        50=>'20.958075,107.071514',
        51=>'16.813969,107.100953',
        52=>'9.602191,105.973697',
        53=>'21.326976,103.914340',
        54=>'11.363962,106.117325',
        55=>'20.445572,106.337189',
        56=>'21.595230,105.838943',
        57=>'19.811854,105.777124',
        58=>'16.463081,107.595328',
        59=>'10.355951,106.366622',
        60=>'9.937783,106.341486',
        61=>'21.819518,105.214511',
        62=>'10.252496,105.967903',
        63=>'21.308974,105.594032',
        64=>'21.706099,104.881310',
        65=>'21.040165,105.827951'
    ];

    protected static $districts = [
        1 => ['id' =>   1, 'name' =>  'Ba Đình', 'parent_code' =>  1, 'path_with_type' => 'Quận Ba Đình, Thành phố Hà Nội', 'type' => 'quan'],
        2 => ['id' =>   2, 'name' =>  'Hoàn Kiếm', 'parent_code' =>  1, 'path_with_type' => 'Quận Hoàn Kiếm, Thành phố Hà Nội', 'type' => 'quan'],
        3 => ['id' =>   3, 'name' =>  'Tây Hồ', 'parent_code' =>  1, 'path_with_type' => 'Quận Tây Hồ, Thành phố Hà Nội', 'type' => 'quan'],
        4 => ['id' =>   4, 'name' =>  'Long Biên', 'parent_code' =>  1, 'path_with_type' => 'Quận Long Biên, Thành phố Hà Nội', 'type' => 'quan'],
        5 => ['id' =>   5, 'name' =>  'Cầu Giấy', 'parent_code' =>  1, 'path_with_type' => 'Quận Cầu Giấy, Thành phố Hà Nội', 'type' => 'quan'],
        6 => ['id' =>   6, 'name' =>  'Đống Đa', 'parent_code' =>  1, 'path_with_type' => 'Quận Đống Đa, Thành phố Hà Nội', 'type' => 'quan'],
        7 => ['id' =>   7, 'name' =>  'Hai Bà Trưng', 'parent_code' =>  1, 'path_with_type' => 'Quận Hai Bà Trưng, Thành phố Hà Nội', 'type' => 'quan'],
        8 => ['id' =>   8, 'name' =>  'Hoàng Mai', 'parent_code' =>  1, 'path_with_type' => 'Quận Hoàng Mai, Thành phố Hà Nội', 'type' => 'quan'],
        9 => ['id' =>   9, 'name' =>  'Thanh Xuân', 'parent_code' =>  1, 'path_with_type' => 'Quận Thanh Xuân, Thành phố Hà Nội', 'type' => 'quan'],
        16 => ['id' =>  16, 'name' =>  'Sóc Sơn', 'parent_code' =>  1, 'path_with_type' => 'Huyện Sóc Sơn, Thành phố Hà Nội', 'type' => 'huyen'],
        17 => ['id' =>  17, 'name' =>  'Đông Anh', 'parent_code' =>  1, 'path_with_type' => 'Huyện Đông Anh, Thành phố Hà Nội', 'type' => 'huyen'],
        18 => ['id' =>  18, 'name' =>  'Gia Lâm', 'parent_code' =>  1, 'path_with_type' => 'Huyện Gia Lâm, Thành phố Hà Nội', 'type' => 'huyen'],
        19 => ['id' =>  19, 'name' =>  'Nam Từ Liêm', 'parent_code' =>  1, 'path_with_type' => 'Quận Nam Từ Liêm, Thành phố Hà Nội', 'type' => 'quan'],
        20 => ['id' =>  20, 'name' =>  'Thanh Trì', 'parent_code' =>  1, 'path_with_type' => 'Huyện Thanh Trì, Thành phố Hà Nội', 'type' => 'huyen'],
        21 => ['id' =>  21, 'name' =>  'Bắc Từ Liêm', 'parent_code' =>  1, 'path_with_type' => 'Quận Bắc Từ Liêm, Thành phố Hà Nội', 'type' => 'quan'],
        24 => ['id' =>  24, 'name' =>  'Hà Giang', 'parent_code' =>  24, 'path_with_type' => 'Thành phố Hà Giang, Tỉnh Hà Giang', 'type' => 'thanh-pho'],
        26 => ['id' =>  26, 'name' =>  'Đồng Văn', 'parent_code' =>  24, 'path_with_type' => 'Huyện Đồng Văn, Tỉnh Hà Giang', 'type' => 'huyen'],
        27 => ['id' =>  27, 'name' =>  'Mèo Vạc', 'parent_code' =>  24, 'path_with_type' => 'Huyện Mèo Vạc, Tỉnh Hà Giang', 'type' => 'huyen'],
        28 => ['id' =>  28, 'name' =>  'Yên Minh', 'parent_code' =>  24, 'path_with_type' => 'Huyện Yên Minh, Tỉnh Hà Giang', 'type' => 'huyen'],
        29 => ['id' =>  29, 'name' =>  'Quản Bạ', 'parent_code' =>  24, 'path_with_type' => 'Huyện Quản Bạ, Tỉnh Hà Giang', 'type' => 'huyen'],
        30 => ['id' =>  30, 'name' =>  'Vị Xuyên', 'parent_code' =>  24, 'path_with_type' => 'Huyện Vị Xuyên, Tỉnh Hà Giang', 'type' => 'huyen'],
        31 => ['id' =>  31, 'name' =>  'Bắc Mê', 'parent_code' =>  24, 'path_with_type' => 'Huyện Bắc Mê, Tỉnh Hà Giang', 'type' => 'huyen'],
        32 => ['id' =>  32, 'name' =>  'Hoàng Su Phì', 'parent_code' =>  24, 'path_with_type' => 'Huyện Hoàng Su Phì, Tỉnh Hà Giang', 'type' => 'huyen'],
        33 => ['id' =>  33, 'name' =>  'Xín Mần', 'parent_code' =>  24, 'path_with_type' => 'Huyện Xín Mần, Tỉnh Hà Giang', 'type' => 'huyen'],
        34 => ['id' =>  34, 'name' =>  'Bắc Quang', 'parent_code' =>  24, 'path_with_type' => 'Huyện Bắc Quang, Tỉnh Hà Giang', 'type' => 'huyen'],
        35 => ['id' =>  35, 'name' =>  'Quang Bình', 'parent_code' =>  24, 'path_with_type' => 'Huyện Quang Bình, Tỉnh Hà Giang', 'type' => 'huyen'],
        40 => ['id' =>  40, 'name' =>  'Cao Bằng', 'parent_code' =>  14, 'path_with_type' => 'Thành phố Cao Bằng, Tỉnh Cao Bằng', 'type' => 'thanh-pho'],
        42 => ['id' =>  42, 'name' =>  'Bảo Lâm', 'parent_code' =>  14, 'path_with_type' => 'Huyện Bảo Lâm, Tỉnh Cao Bằng', 'type' => 'huyen'],
        43 => ['id' =>  43, 'name' =>  'Bảo Lạc', 'parent_code' =>  14, 'path_with_type' => 'Huyện Bảo Lạc, Tỉnh Cao Bằng', 'type' => 'huyen'],
        44 => ['id' =>  44, 'name' =>  'Thông Nông', 'parent_code' =>  14, 'path_with_type' => 'Huyện Thông Nông, Tỉnh Cao Bằng', 'type' => 'huyen'],
        45 => ['id' =>  45, 'name' =>  'Hà Quảng', 'parent_code' =>  14, 'path_with_type' => 'Huyện Hà Quảng, Tỉnh Cao Bằng', 'type' => 'huyen'],
        46 => ['id' =>  46, 'name' =>  'Trà Lĩnh', 'parent_code' =>  14, 'path_with_type' => 'Huyện Trà Lĩnh, Tỉnh Cao Bằng', 'type' => 'huyen'],
        47 => ['id' =>  47, 'name' =>  'Trùng Khánh', 'parent_code' =>  14, 'path_with_type' => 'Huyện Trùng Khánh, Tỉnh Cao Bằng', 'type' => 'huyen'],
        48 => ['id' =>  48, 'name' =>  'Hạ Lang', 'parent_code' =>  14, 'path_with_type' => 'Huyện Hạ Lang, Tỉnh Cao Bằng', 'type' => 'huyen'],
        49 => ['id' =>  49, 'name' =>  'Quảng Uyên', 'parent_code' =>  14, 'path_with_type' => 'Huyện Quảng Uyên, Tỉnh Cao Bằng', 'type' => 'huyen'],
        50 => ['id' =>  50, 'name' =>  'Phục Hoà', 'parent_code' =>  14, 'path_with_type' => 'Huyện Phục Hoà, Tỉnh Cao Bằng', 'type' => 'huyen'],
        51 => ['id' =>  51, 'name' =>  'Hoà An', 'parent_code' =>  14, 'path_with_type' => 'Huyện Hoà An, Tỉnh Cao Bằng', 'type' => 'huyen'],
        52 => ['id' =>  52, 'name' =>  'Nguyên Bình', 'parent_code' =>  14, 'path_with_type' => 'Huyện Nguyên Bình, Tỉnh Cao Bằng', 'type' => 'huyen'],
        53 => ['id' =>  53, 'name' =>  'Thạch An', 'parent_code' =>  14, 'path_with_type' => 'Huyện Thạch An, Tỉnh Cao Bằng', 'type' => 'huyen'],
        58 => ['id' =>  58, 'name' =>  'Bắc Kạn', 'parent_code' =>  6, 'path_with_type' => 'Thành Phố Bắc Kạn, Tỉnh Bắc Kạn', 'type' => 'thanh-pho'],
        60 => ['id' =>  60, 'name' =>  'Pác Nặm', 'parent_code' =>  6, 'path_with_type' => 'Huyện Pác Nặm, Tỉnh Bắc Kạn', 'type' => 'huyen'],
        61 => ['id' =>  61, 'name' =>  'Ba Bể', 'parent_code' =>  6, 'path_with_type' => 'Huyện Ba Bể, Tỉnh Bắc Kạn', 'type' => 'huyen'],
        62 => ['id' =>  62, 'name' =>  'Ngân Sơn', 'parent_code' =>  6, 'path_with_type' => 'Huyện Ngân Sơn, Tỉnh Bắc Kạn', 'type' => 'huyen'],
        63 => ['id' =>  63, 'name' =>  'Bạch Thông', 'parent_code' =>  6, 'path_with_type' => 'Huyện Bạch Thông, Tỉnh Bắc Kạn', 'type' => 'huyen'],
        64 => ['id' =>  64, 'name' =>  'Chợ Đồn', 'parent_code' =>  6, 'path_with_type' => 'Huyện Chợ Đồn, Tỉnh Bắc Kạn', 'type' => 'huyen'],
        65 => ['id' =>  65, 'name' =>  'Chợ Mới', 'parent_code' =>  6, 'path_with_type' => 'Huyện Chợ Mới, Tỉnh Bắc Kạn', 'type' => 'huyen'],
        66 => ['id' =>  66, 'name' =>  'Na Rì', 'parent_code' =>  6, 'path_with_type' => 'Huyện Na Rì, Tỉnh Bắc Kạn', 'type' => 'huyen'],
        70 => ['id' =>  70, 'name' =>  'Tuyên Quang', 'parent_code' =>  61, 'path_with_type' => 'Thành phố Tuyên Quang, Tỉnh Tuyên Quang', 'type' => 'thanh-pho'],
        71 => ['id' =>  71, 'name' =>  'Lâm Bình', 'parent_code' =>  61, 'path_with_type' => 'Huyện Lâm Bình, Tỉnh Tuyên Quang', 'type' => 'huyen'],
        72 => ['id' =>  72, 'name' =>  'Nà Hang', 'parent_code' =>  61, 'path_with_type' => 'Huyện Nà Hang, Tỉnh Tuyên Quang', 'type' => 'huyen'],
        73 => ['id' =>  73, 'name' =>  'Chiêm Hóa', 'parent_code' =>  61, 'path_with_type' => 'Huyện Chiêm Hóa, Tỉnh Tuyên Quang', 'type' => 'huyen'],
        74 => ['id' =>  74, 'name' =>  'Hàm Yên', 'parent_code' =>  61, 'path_with_type' => 'Huyện Hàm Yên, Tỉnh Tuyên Quang', 'type' => 'huyen'],
        75 => ['id' =>  75, 'name' =>  'Yên Sơn', 'parent_code' =>  61, 'path_with_type' => 'Huyện Yên Sơn, Tỉnh Tuyên Quang', 'type' => 'huyen'],
        76 => ['id' =>  76, 'name' =>  'Sơn Dương', 'parent_code' =>  61, 'path_with_type' => 'Huyện Sơn Dương, Tỉnh Tuyên Quang', 'type' => 'huyen'],
        80 => ['id' =>  80, 'name' =>  'Lào Cai', 'parent_code' =>  38, 'path_with_type' => 'Thành phố Lào Cai, Tỉnh Lào Cai', 'type' => 'thanh-pho'],
        82 => ['id' =>  82, 'name' =>  'Bát Xát', 'parent_code' =>  38, 'path_with_type' => 'Huyện Bát Xát, Tỉnh Lào Cai', 'type' => 'huyen'],
        83 => ['id' =>  83, 'name' =>  'Mường Khương', 'parent_code' =>  38, 'path_with_type' => 'Huyện Mường Khương, Tỉnh Lào Cai', 'type' => 'huyen'],
        84 => ['id' =>  84, 'name' =>  'Si Ma Cai', 'parent_code' =>  38, 'path_with_type' => 'Huyện Si Ma Cai, Tỉnh Lào Cai', 'type' => 'huyen'],
        85 => ['id' =>  85, 'name' =>  'Bắc Hà', 'parent_code' =>  38, 'path_with_type' => 'Huyện Bắc Hà, Tỉnh Lào Cai', 'type' => 'huyen'],
        86 => ['id' =>  86, 'name' =>  'Bảo Thắng', 'parent_code' =>  38, 'path_with_type' => 'Huyện Bảo Thắng, Tỉnh Lào Cai', 'type' => 'huyen'],
        87 => ['id' =>  87, 'name' =>  'Bảo Yên', 'parent_code' =>  38, 'path_with_type' => 'Huyện Bảo Yên, Tỉnh Lào Cai', 'type' => 'huyen'],
        88 => ['id' =>  88, 'name' =>  'Sa Pa', 'parent_code' =>  38, 'path_with_type' => 'Huyện Sa Pa, Tỉnh Lào Cai', 'type' => 'huyen'],
        89 => ['id' =>  89, 'name' =>  'Văn Bàn', 'parent_code' =>  38, 'path_with_type' => 'Huyện Văn Bàn, Tỉnh Lào Cai', 'type' => 'huyen'],
        94 => ['id' =>  94, 'name' =>  'Điện Biên Phủ', 'parent_code' =>  20, 'path_with_type' => 'Thành phố Điện Biên Phủ, Tỉnh Điện Biên', 'type' => 'thanh-pho'],
        95 => ['id' =>  95, 'name' =>  'Mường Lay', 'parent_code' =>  20, 'path_with_type' => 'Thị xã Mường Lay, Tỉnh Điện Biên', 'type' => 'thi-xa'],
        96 => ['id' =>  96, 'name' =>  'Mường Nhé', 'parent_code' =>  20, 'path_with_type' => 'Huyện Mường Nhé, Tỉnh Điện Biên', 'type' => 'huyen'],
        97 => ['id' =>  97, 'name' =>  'Mường Chà', 'parent_code' =>  20, 'path_with_type' => 'Huyện Mường Chà, Tỉnh Điện Biên', 'type' => 'huyen'],
        98 => ['id' =>  98, 'name' =>  'Tủa Chùa', 'parent_code' =>  20, 'path_with_type' => 'Huyện Tủa Chùa, Tỉnh Điện Biên', 'type' => 'huyen'],
        99 => ['id' =>  99, 'name' =>  'Tuần Giáo', 'parent_code' =>  20, 'path_with_type' => 'Huyện Tuần Giáo, Tỉnh Điện Biên', 'type' => 'huyen'],
        100 => ['id' => 100, 'name' =>  'Điện Biên', 'parent_code' =>  20, 'path_with_type' => 'Huyện Điện Biên, Tỉnh Điện Biên', 'type' => 'huyen'],
        101 => ['id' => 101, 'name' =>  'Điện Biên Đông', 'parent_code' =>  20, 'path_with_type' => 'Huyện Điện Biên Đông, Tỉnh Điện Biên', 'type' => 'huyen'],
        102 => ['id' => 102, 'name' =>  'Mường Ảng', 'parent_code' =>  20, 'path_with_type' => 'Huyện Mường Ảng, Tỉnh Điện Biên', 'type' => 'huyen'],
        103 => ['id' => 103, 'name' =>  'Nậm Pồ', 'parent_code' =>  20, 'path_with_type' => 'Huyện Nậm Pồ, Tỉnh Điện Biên', 'type' => 'huyen'],
        105 => ['id' => 105, 'name' =>  'Lai Châu', 'parent_code' =>  36, 'path_with_type' => 'Thành phố Lai Châu, Tỉnh Lai Châu', 'type' => 'thanh-pho'],
        106 => ['id' => 106, 'name' =>  'Tam Đường', 'parent_code' =>  36, 'path_with_type' => 'Huyện Tam Đường, Tỉnh Lai Châu', 'type' => 'huyen'],
        107 => ['id' => 107, 'name' =>  'Mường Tè', 'parent_code' =>  36, 'path_with_type' => 'Huyện Mường Tè, Tỉnh Lai Châu', 'type' => 'huyen'],
        108 => ['id' => 108, 'name' =>  'Sìn Hồ', 'parent_code' =>  36, 'path_with_type' => 'Huyện Sìn Hồ, Tỉnh Lai Châu', 'type' => 'huyen'],
        109 => ['id' => 109, 'name' =>  'Phong Thổ', 'parent_code' =>  36, 'path_with_type' => 'Huyện Phong Thổ, Tỉnh Lai Châu', 'type' => 'huyen'],
        110 => ['id' => 110, 'name' =>  'Than Uyên', 'parent_code' =>  36, 'path_with_type' => 'Huyện Than Uyên, Tỉnh Lai Châu', 'type' => 'huyen'],
        111 => ['id' => 111, 'name' =>  'Tân Uyên', 'parent_code' =>  36, 'path_with_type' => 'Huyện Tân Uyên, Tỉnh Lai Châu', 'type' => 'huyen'],
        112 => ['id' => 112, 'name' =>  'Nậm Nhùn', 'parent_code' =>  36, 'path_with_type' => 'Huyện Nậm Nhùn, Tỉnh Lai Châu', 'type' => 'huyen'],
        116 => ['id' => 116, 'name' =>  'Sơn La', 'parent_code' =>  53, 'path_with_type' => 'Thành phố Sơn La, Tỉnh Sơn La', 'type' => 'thanh-pho'],
        118 => ['id' => 118, 'name' =>  'Quỳnh Nhai', 'parent_code' =>  53, 'path_with_type' => 'Huyện Quỳnh Nhai, Tỉnh Sơn La', 'type' => 'huyen'],
        119 => ['id' => 119, 'name' =>  'Thuận Châu', 'parent_code' =>  53, 'path_with_type' => 'Huyện Thuận Châu, Tỉnh Sơn La', 'type' => 'huyen'],
        120 => ['id' => 120, 'name' =>  'Mường La', 'parent_code' =>  53, 'path_with_type' => 'Huyện Mường La, Tỉnh Sơn La', 'type' => 'huyen'],
        121 => ['id' => 121, 'name' =>  'Bắc Yên', 'parent_code' =>  53, 'path_with_type' => 'Huyện Bắc Yên, Tỉnh Sơn La', 'type' => 'huyen'],
        122 => ['id' => 122, 'name' =>  'Phù Yên', 'parent_code' =>  53, 'path_with_type' => 'Huyện Phù Yên, Tỉnh Sơn La', 'type' => 'huyen'],
        123 => ['id' => 123, 'name' =>  'Mộc Châu', 'parent_code' =>  53, 'path_with_type' => 'Huyện Mộc Châu, Tỉnh Sơn La', 'type' => 'huyen'],
        124 => ['id' => 124, 'name' =>  'Yên Châu', 'parent_code' =>  53, 'path_with_type' => 'Huyện Yên Châu, Tỉnh Sơn La', 'type' => 'huyen'],
        125 => ['id' => 125, 'name' =>  'Mai Sơn', 'parent_code' =>  53, 'path_with_type' => 'Huyện Mai Sơn, Tỉnh Sơn La', 'type' => 'huyen'],
        126 => ['id' => 126, 'name' =>  'Sông Mã', 'parent_code' =>  53, 'path_with_type' => 'Huyện Sông Mã, Tỉnh Sơn La', 'type' => 'huyen'],
        127 => ['id' => 127, 'name' =>  'Sốp Cộp', 'parent_code' =>  53, 'path_with_type' => 'Huyện Sốp Cộp, Tỉnh Sơn La', 'type' => 'huyen'],
        128 => ['id' => 128, 'name' =>  'Vân Hồ', 'parent_code' =>  53, 'path_with_type' => 'Huyện Vân Hồ, Tỉnh Sơn La', 'type' => 'huyen'],
        132 => ['id' => 132, 'name' =>  'Yên Bái', 'parent_code' =>  64, 'path_with_type' => 'Thành phố Yên Bái, Tỉnh Yên Bái', 'type' => 'thanh-pho'],
        133 => ['id' => 133, 'name' =>  'Nghĩa Lộ', 'parent_code' =>  64, 'path_with_type' => 'Thị xã Nghĩa Lộ, Tỉnh Yên Bái', 'type' => 'thi-xa'],
        135 => ['id' => 135, 'name' =>  'Lục Yên', 'parent_code' =>  64, 'path_with_type' => 'Huyện Lục Yên, Tỉnh Yên Bái', 'type' => 'huyen'],
        136 => ['id' => 136, 'name' =>  'Văn Yên', 'parent_code' =>  64, 'path_with_type' => 'Huyện Văn Yên, Tỉnh Yên Bái', 'type' => 'huyen'],
        137 => ['id' => 137, 'name' =>  'Mù Căng Chải', 'parent_code' =>  64, 'path_with_type' => 'Huyện Mù Căng Chải, Tỉnh Yên Bái', 'type' => 'huyen'],
        138 => ['id' => 138, 'name' =>  'Trấn Yên', 'parent_code' =>  64, 'path_with_type' => 'Huyện Trấn Yên, Tỉnh Yên Bái', 'type' => 'huyen'],
        139 => ['id' => 139, 'name' =>  'Trạm Tấu', 'parent_code' =>  64, 'path_with_type' => 'Huyện Trạm Tấu, Tỉnh Yên Bái', 'type' => 'huyen'],
        140 => ['id' => 140, 'name' =>  'Văn Chấn', 'parent_code' =>  64, 'path_with_type' => 'Huyện Văn Chấn, Tỉnh Yên Bái', 'type' => 'huyen'],
        141 => ['id' => 141, 'name' =>  'Yên Bình', 'parent_code' =>  64, 'path_with_type' => 'Huyện Yên Bình, Tỉnh Yên Bái', 'type' => 'huyen'],
        148 => ['id' => 148, 'name' =>  'Hòa Bình', 'parent_code' =>  31, 'path_with_type' => 'Thành phố Hòa Bình, Tỉnh Hoà Bình', 'type' => 'thanh-pho'],
        150 => ['id' => 150, 'name' =>  'Đà Bắc', 'parent_code' =>  31, 'path_with_type' => 'Huyện Đà Bắc, Tỉnh Hoà Bình', 'type' => 'huyen'],
        151 => ['id' => 151, 'name' =>  'Kỳ Sơn', 'parent_code' =>  31, 'path_with_type' => 'Huyện Kỳ Sơn, Tỉnh Hoà Bình', 'type' => 'huyen'],
        152 => ['id' => 152, 'name' =>  'Lương Sơn', 'parent_code' =>  31, 'path_with_type' => 'Huyện Lương Sơn, Tỉnh Hoà Bình', 'type' => 'huyen'],
        153 => ['id' => 153, 'name' =>  'Kim Bôi', 'parent_code' =>  31, 'path_with_type' => 'Huyện Kim Bôi, Tỉnh Hoà Bình', 'type' => 'huyen'],
        154 => ['id' => 154, 'name' =>  'Cao Phong', 'parent_code' =>  31, 'path_with_type' => 'Huyện Cao Phong, Tỉnh Hoà Bình', 'type' => 'huyen'],
        155 => ['id' => 155, 'name' =>  'Tân Lạc', 'parent_code' =>  31, 'path_with_type' => 'Huyện Tân Lạc, Tỉnh Hoà Bình', 'type' => 'huyen'],
        156 => ['id' => 156, 'name' =>  'Mai Châu', 'parent_code' =>  31, 'path_with_type' => 'Huyện Mai Châu, Tỉnh Hoà Bình', 'type' => 'huyen'],
        157 => ['id' => 157, 'name' =>  'Lạc Sơn', 'parent_code' =>  31, 'path_with_type' => 'Huyện Lạc Sơn, Tỉnh Hoà Bình', 'type' => 'huyen'],
        158 => ['id' => 158, 'name' =>  'Yên Thủy', 'parent_code' =>  31, 'path_with_type' => 'Huyện Yên Thủy, Tỉnh Hoà Bình', 'type' => 'huyen'],
        159 => ['id' => 159, 'name' =>  'Lạc Thủy', 'parent_code' =>  31, 'path_with_type' => 'Huyện Lạc Thủy, Tỉnh Hoà Bình', 'type' => 'huyen'],
        164 => ['id' => 164, 'name' =>  'Thái Nguyên', 'parent_code' =>  56, 'path_with_type' => 'Thành phố Thái Nguyên, Tỉnh Thái Nguyên', 'type' => 'thanh-pho'],
        165 => ['id' => 165, 'name' =>  'Sông Công', 'parent_code' =>  56, 'path_with_type' => 'Thành phố Sông Công, Tỉnh Thái Nguyên', 'type' => 'thanh-pho'],
        167 => ['id' => 167, 'name' =>  'Định Hóa', 'parent_code' =>  56, 'path_with_type' => 'Huyện Định Hóa, Tỉnh Thái Nguyên', 'type' => 'huyen'],
        168 => ['id' => 168, 'name' =>  'Phú Lương', 'parent_code' =>  56, 'path_with_type' => 'Huyện Phú Lương, Tỉnh Thái Nguyên', 'type' => 'huyen'],
        169 => ['id' => 169, 'name' =>  'Đồng Hỷ', 'parent_code' =>  56, 'path_with_type' => 'Huyện Đồng Hỷ, Tỉnh Thái Nguyên', 'type' => 'huyen'],
        170 => ['id' => 170, 'name' =>  'Võ Nhai', 'parent_code' =>  56, 'path_with_type' => 'Huyện Võ Nhai, Tỉnh Thái Nguyên', 'type' => 'huyen'],
        171 => ['id' => 171, 'name' =>  'Đại Từ', 'parent_code' =>  56, 'path_with_type' => 'Huyện Đại Từ, Tỉnh Thái Nguyên', 'type' => 'huyen'],
        172 => ['id' => 172, 'name' =>  'Phổ Yên', 'parent_code' =>  56, 'path_with_type' => 'Thị xã Phổ Yên, Tỉnh Thái Nguyên', 'type' => 'thi-xa'],
        173 => ['id' => 173, 'name' =>  'Phú Bình', 'parent_code' =>  56, 'path_with_type' => 'Huyện Phú Bình, Tỉnh Thái Nguyên', 'type' => 'huyen'],
        178 => ['id' => 178, 'name' =>  'Lạng Sơn', 'parent_code' =>  37, 'path_with_type' => 'Thành phố Lạng Sơn, Tỉnh Lạng Sơn', 'type' => 'thanh-pho'],
        180 => ['id' => 180, 'name' =>  'Tràng Định', 'parent_code' =>  37, 'path_with_type' => 'Huyện Tràng Định, Tỉnh Lạng Sơn', 'type' => 'huyen'],
        181 => ['id' => 181, 'name' =>  'Bình Gia', 'parent_code' =>  37, 'path_with_type' => 'Huyện Bình Gia, Tỉnh Lạng Sơn', 'type' => 'huyen'],
        182 => ['id' => 182, 'name' =>  'Văn Lãng', 'parent_code' =>  37, 'path_with_type' => 'Huyện Văn Lãng, Tỉnh Lạng Sơn', 'type' => 'huyen'],
        183 => ['id' => 183, 'name' =>  'Cao Lộc', 'parent_code' =>  37, 'path_with_type' => 'Huyện Cao Lộc, Tỉnh Lạng Sơn', 'type' => 'huyen'],
        184 => ['id' => 184, 'name' =>  'Văn Quan', 'parent_code' =>  37, 'path_with_type' => 'Huyện Văn Quan, Tỉnh Lạng Sơn', 'type' => 'huyen'],
        185 => ['id' => 185, 'name' =>  'Bắc Sơn', 'parent_code' =>  37, 'path_with_type' => 'Huyện Bắc Sơn, Tỉnh Lạng Sơn', 'type' => 'huyen'],
        186 => ['id' => 186, 'name' =>  'Hữu Lũng', 'parent_code' =>  37, 'path_with_type' => 'Huyện Hữu Lũng, Tỉnh Lạng Sơn', 'type' => 'huyen'],
        187 => ['id' => 187, 'name' =>  'Chi Lăng', 'parent_code' =>  37, 'path_with_type' => 'Huyện Chi Lăng, Tỉnh Lạng Sơn', 'type' => 'huyen'],
        188 => ['id' => 188, 'name' =>  'Lộc Bình', 'parent_code' =>  37, 'path_with_type' => 'Huyện Lộc Bình, Tỉnh Lạng Sơn', 'type' => 'huyen'],
        189 => ['id' => 189, 'name' =>  'Đình Lập', 'parent_code' =>  37, 'path_with_type' => 'Huyện Đình Lập, Tỉnh Lạng Sơn', 'type' => 'huyen'],
        193 => ['id' => 193, 'name' =>  'Hạ Long', 'parent_code' =>  50, 'path_with_type' => 'Thành phố Hạ Long, Tỉnh Quảng Ninh', 'type' => 'thanh-pho'],
        194 => ['id' => 194, 'name' =>  'Móng Cái', 'parent_code' =>  50, 'path_with_type' => 'Thành phố Móng Cái, Tỉnh Quảng Ninh', 'type' => 'thanh-pho'],
        195 => ['id' => 195, 'name' =>  'Cẩm Phả', 'parent_code' =>  50, 'path_with_type' => 'Thành phố Cẩm Phả, Tỉnh Quảng Ninh', 'type' => 'thanh-pho'],
        196 => ['id' => 196, 'name' =>  'Uông Bí', 'parent_code' =>  50, 'path_with_type' => 'Thành phố Uông Bí, Tỉnh Quảng Ninh', 'type' => 'thanh-pho'],
        198 => ['id' => 198, 'name' =>  'Bình Liêu', 'parent_code' =>  50, 'path_with_type' => 'Huyện Bình Liêu, Tỉnh Quảng Ninh', 'type' => 'huyen'],
        199 => ['id' => 199, 'name' =>  'Tiên Yên', 'parent_code' =>  50, 'path_with_type' => 'Huyện Tiên Yên, Tỉnh Quảng Ninh', 'type' => 'huyen'],
        200 => ['id' => 200, 'name' =>  'Đầm Hà', 'parent_code' =>  50, 'path_with_type' => 'Huyện Đầm Hà, Tỉnh Quảng Ninh', 'type' => 'huyen'],
        201 => ['id' => 201, 'name' =>  'Hải Hà', 'parent_code' =>  50, 'path_with_type' => 'Huyện Hải Hà, Tỉnh Quảng Ninh', 'type' => 'huyen'],
        202 => ['id' => 202, 'name' =>  'Ba Chẽ', 'parent_code' =>  50, 'path_with_type' => 'Huyện Ba Chẽ, Tỉnh Quảng Ninh', 'type' => 'huyen'],
        203 => ['id' => 203, 'name' =>  'Vân Đồn', 'parent_code' =>  50, 'path_with_type' => 'Huyện Vân Đồn, Tỉnh Quảng Ninh', 'type' => 'huyen'],
        204 => ['id' => 204, 'name' =>  'Hoành Bồ', 'parent_code' =>  50, 'path_with_type' => 'Huyện Hoành Bồ, Tỉnh Quảng Ninh', 'type' => 'huyen'],
        205 => ['id' => 205, 'name' =>  'Đông Triều', 'parent_code' =>  50, 'path_with_type' => 'Thị xã Đông Triều, Tỉnh Quảng Ninh', 'type' => 'thi-xa'],
        206 => ['id' => 206, 'name' =>  'Quảng Yên', 'parent_code' =>  50, 'path_with_type' => 'Thị xã Quảng Yên, Tỉnh Quảng Ninh', 'type' => 'thi-xa'],
        207 => ['id' => 207, 'name' =>  'Cô Tô', 'parent_code' =>  50, 'path_with_type' => 'Huyện Cô Tô, Tỉnh Quảng Ninh', 'type' => 'huyen'],
        213 => ['id' => 213, 'name' =>  'Bắc Giang', 'parent_code' =>  7, 'path_with_type' => 'Thành phố Bắc Giang, Tỉnh Bắc Giang', 'type' => 'thanh-pho'],
        215 => ['id' => 215, 'name' =>  'Yên Thế', 'parent_code' =>  7, 'path_with_type' => 'Huyện Yên Thế, Tỉnh Bắc Giang', 'type' => 'huyen'],
        216 => ['id' => 216, 'name' =>  'Tân Yên', 'parent_code' =>  7, 'path_with_type' => 'Huyện Tân Yên, Tỉnh Bắc Giang', 'type' => 'huyen'],
        217 => ['id' => 217, 'name' =>  'Lạng Giang', 'parent_code' =>  7, 'path_with_type' => 'Huyện Lạng Giang, Tỉnh Bắc Giang', 'type' => 'huyen'],
        218 => ['id' => 218, 'name' =>  'Lục Nam', 'parent_code' =>  7, 'path_with_type' => 'Huyện Lục Nam, Tỉnh Bắc Giang', 'type' => 'huyen'],
        219 => ['id' => 219, 'name' =>  'Lục Ngạn', 'parent_code' =>  7, 'path_with_type' => 'Huyện Lục Ngạn, Tỉnh Bắc Giang', 'type' => 'huyen'],
        220 => ['id' => 220, 'name' =>  'Sơn Động', 'parent_code' =>  7, 'path_with_type' => 'Huyện Sơn Động, Tỉnh Bắc Giang', 'type' => 'huyen'],
        221 => ['id' => 221, 'name' =>  'Yên Dũng', 'parent_code' =>  7, 'path_with_type' => 'Huyện Yên Dũng, Tỉnh Bắc Giang', 'type' => 'huyen'],
        222 => ['id' => 222, 'name' =>  'Việt Yên', 'parent_code' =>  7, 'path_with_type' => 'Huyện Việt Yên, Tỉnh Bắc Giang', 'type' => 'huyen'],
        223 => ['id' => 223, 'name' =>  'Hiệp Hòa', 'parent_code' =>  7, 'path_with_type' => 'Huyện Hiệp Hòa, Tỉnh Bắc Giang', 'type' => 'huyen'],
        227 => ['id' => 227, 'name' =>  'Việt Trì', 'parent_code' =>  45, 'path_with_type' => 'Thành phố Việt Trì, Tỉnh Phú Thọ', 'type' => 'thanh-pho'],
        228 => ['id' => 228, 'name' =>  'Phú Thọ', 'parent_code' =>  45, 'path_with_type' => 'Thị xã Phú Thọ, Tỉnh Phú Thọ', 'type' => 'thi-xa'],
        230 => ['id' => 230, 'name' =>  'Đoan Hùng', 'parent_code' =>  45, 'path_with_type' => 'Huyện Đoan Hùng, Tỉnh Phú Thọ', 'type' => 'huyen'],
        231 => ['id' => 231, 'name' =>  'Hạ Hoà', 'parent_code' =>  45, 'path_with_type' => 'Huyện Hạ Hoà, Tỉnh Phú Thọ', 'type' => 'huyen'],
        232 => ['id' => 232, 'name' =>  'Thanh Ba', 'parent_code' =>  45, 'path_with_type' => 'Huyện Thanh Ba, Tỉnh Phú Thọ', 'type' => 'huyen'],
        233 => ['id' => 233, 'name' =>  'Phù Ninh', 'parent_code' =>  45, 'path_with_type' => 'Huyện Phù Ninh, Tỉnh Phú Thọ', 'type' => 'huyen'],
        234 => ['id' => 234, 'name' =>  'Yên Lập', 'parent_code' =>  45, 'path_with_type' => 'Huyện Yên Lập, Tỉnh Phú Thọ', 'type' => 'huyen'],
        235 => ['id' => 235, 'name' =>  'Cẩm Khê', 'parent_code' =>  45, 'path_with_type' => 'Huyện Cẩm Khê, Tỉnh Phú Thọ', 'type' => 'huyen'],
        236 => ['id' => 236, 'name' =>  'Tam Nông', 'parent_code' =>  45, 'path_with_type' => 'Huyện Tam Nông, Tỉnh Phú Thọ', 'type' => 'huyen'],
        237 => ['id' => 237, 'name' =>  'Lâm Thao', 'parent_code' =>  45, 'path_with_type' => 'Huyện Lâm Thao, Tỉnh Phú Thọ', 'type' => 'huyen'],
        238 => ['id' => 238, 'name' =>  'Thanh Sơn', 'parent_code' =>  45, 'path_with_type' => 'Huyện Thanh Sơn, Tỉnh Phú Thọ', 'type' => 'huyen'],
        239 => ['id' => 239, 'name' =>  'Thanh Thuỷ', 'parent_code' =>  45, 'path_with_type' => 'Huyện Thanh Thuỷ, Tỉnh Phú Thọ', 'type' => 'huyen'],
        240 => ['id' => 240, 'name' =>  'Tân Sơn', 'parent_code' =>  45, 'path_with_type' => 'Huyện Tân Sơn, Tỉnh Phú Thọ', 'type' => 'huyen'],
        243 => ['id' => 243, 'name' =>  'Vĩnh Yên', 'parent_code' =>  63, 'path_with_type' => 'Thành phố Vĩnh Yên, Tỉnh Vĩnh Phúc', 'type' => 'thanh-pho'],
        244 => ['id' => 244, 'name' =>  'Phúc Yên', 'parent_code' =>  63, 'path_with_type' => 'Thị xã Phúc Yên, Tỉnh Vĩnh Phúc', 'type' => 'thi-xa'],
        246 => ['id' => 246, 'name' =>  'Lập Thạch', 'parent_code' =>  63, 'path_with_type' => 'Huyện Lập Thạch, Tỉnh Vĩnh Phúc', 'type' => 'huyen'],
        247 => ['id' => 247, 'name' =>  'Tam Dương', 'parent_code' =>  63, 'path_with_type' => 'Huyện Tam Dương, Tỉnh Vĩnh Phúc', 'type' => 'huyen'],
        248 => ['id' => 248, 'name' =>  'Tam Đảo', 'parent_code' =>  63, 'path_with_type' => 'Huyện Tam Đảo, Tỉnh Vĩnh Phúc', 'type' => 'huyen'],
        249 => ['id' => 249, 'name' =>  'Bình Xuyên', 'parent_code' =>  63, 'path_with_type' => 'Huyện Bình Xuyên, Tỉnh Vĩnh Phúc', 'type' => 'huyen'],
        250 => ['id' => 250, 'name' =>  'Mê Linh', 'parent_code' =>  1, 'path_with_type' => 'Huyện Mê Linh, Thành phố Hà Nội', 'type' => 'huyen'],
        251 => ['id' => 251, 'name' =>  'Yên Lạc', 'parent_code' =>  63, 'path_with_type' => 'Huyện Yên Lạc, Tỉnh Vĩnh Phúc', 'type' => 'huyen'],
        252 => ['id' => 252, 'name' =>  'Vĩnh Tường', 'parent_code' =>  63, 'path_with_type' => 'Huyện Vĩnh Tường, Tỉnh Vĩnh Phúc', 'type' => 'huyen'],
        253 => ['id' => 253, 'name' =>  'Sông Lô', 'parent_code' =>  63, 'path_with_type' => 'Huyện Sông Lô, Tỉnh Vĩnh Phúc', 'type' => 'huyen'],
        256 => ['id' => 256, 'name' =>  'Bắc Ninh', 'parent_code' =>  8, 'path_with_type' => 'Thành phố Bắc Ninh, Tỉnh Bắc Ninh', 'type' => 'thanh-pho'],
        258 => ['id' => 258, 'name' =>  'Yên Phong', 'parent_code' =>  8, 'path_with_type' => 'Huyện Yên Phong, Tỉnh Bắc Ninh', 'type' => 'huyen'],
        259 => ['id' => 259, 'name' =>  'Quế Võ', 'parent_code' =>  8, 'path_with_type' => 'Huyện Quế Võ, Tỉnh Bắc Ninh', 'type' => 'huyen'],
        260 => ['id' => 260, 'name' =>  'Tiên Du', 'parent_code' =>  8, 'path_with_type' => 'Huyện Tiên Du, Tỉnh Bắc Ninh', 'type' => 'huyen'],
        261 => ['id' => 261, 'name' =>  'Từ Sơn', 'parent_code' =>  8, 'path_with_type' => 'Thị xã Từ Sơn, Tỉnh Bắc Ninh', 'type' => 'thi-xa'],
        262 => ['id' => 262, 'name' =>  'Thuận Thành', 'parent_code' =>  8, 'path_with_type' => 'Huyện Thuận Thành, Tỉnh Bắc Ninh', 'type' => 'huyen'],
        263 => ['id' => 263, 'name' =>  'Gia Bình', 'parent_code' =>  8, 'path_with_type' => 'Huyện Gia Bình, Tỉnh Bắc Ninh', 'type' => 'huyen'],
        264 => ['id' => 264, 'name' =>  'Lương Tài', 'parent_code' =>  8, 'path_with_type' => 'Huyện Lương Tài, Tỉnh Bắc Ninh', 'type' => 'huyen'],
        268 => ['id' => 268, 'name' =>  'Hà Đông', 'parent_code' =>  1, 'path_with_type' => 'Quận Hà Đông, Thành phố Hà Nội', 'type' => 'quan'],
        269 => ['id' => 269, 'name' =>  'Sơn Tây', 'parent_code' =>  1, 'path_with_type' => 'Thị xã Sơn Tây, Thành phố Hà Nội', 'type' => 'thi-xa'],
        271 => ['id' => 271, 'name' =>  'Ba Vì', 'parent_code' =>  1, 'path_with_type' => 'Huyện Ba Vì, Thành phố Hà Nội', 'type' => 'huyen'],
        272 => ['id' => 272, 'name' =>  'Phúc Thọ', 'parent_code' =>  1, 'path_with_type' => 'Huyện Phúc Thọ, Thành phố Hà Nội', 'type' => 'huyen'],
        273 => ['id' => 273, 'name' =>  'Đan Phượng', 'parent_code' =>  1, 'path_with_type' => 'Huyện Đan Phượng, Thành phố Hà Nội', 'type' => 'huyen'],
        274 => ['id' => 274, 'name' =>  'Hoài Đức', 'parent_code' =>  1, 'path_with_type' => 'Huyện Hoài Đức, Thành phố Hà Nội', 'type' => 'huyen'],
        275 => ['id' => 275, 'name' =>  'Quốc Oai', 'parent_code' =>  1, 'path_with_type' => 'Huyện Quốc Oai, Thành phố Hà Nội', 'type' => 'huyen'],
        276 => ['id' => 276, 'name' =>  'Thạch Thất', 'parent_code' =>  1, 'path_with_type' => 'Huyện Thạch Thất, Thành phố Hà Nội', 'type' => 'huyen'],
        277 => ['id' => 277, 'name' =>  'Chương Mỹ', 'parent_code' =>  1, 'path_with_type' => 'Huyện Chương Mỹ, Thành phố Hà Nội', 'type' => 'huyen'],
        278 => ['id' => 278, 'name' =>  'Thanh Oai', 'parent_code' =>  1, 'path_with_type' => 'Huyện Thanh Oai, Thành phố Hà Nội', 'type' => 'huyen'],
        279 => ['id' => 279, 'name' =>  'Thường Tín', 'parent_code' =>  1, 'path_with_type' => 'Huyện Thường Tín, Thành phố Hà Nội', 'type' => 'huyen'],
        280 => ['id' => 280, 'name' =>  'Phú Xuyên', 'parent_code' =>  1, 'path_with_type' => 'Huyện Phú Xuyên, Thành phố Hà Nội', 'type' => 'huyen'],
        281 => ['id' => 281, 'name' =>  'Ứng Hòa', 'parent_code' =>  1, 'path_with_type' => 'Huyện Ứng Hòa, Thành phố Hà Nội', 'type' => 'huyen'],
        282 => ['id' => 282, 'name' =>  'Mỹ Đức', 'parent_code' =>  1, 'path_with_type' => 'Huyện Mỹ Đức, Thành phố Hà Nội', 'type' => 'huyen'],
        288 => ['id' => 288, 'name' =>  'TP. Hải Dương', 'parent_code' =>  28, 'path_with_type' => 'Thành phố Hải Dương, Tỉnh Hải Dương', 'type' => 'thanh-pho'],
        290 => ['id' => 290, 'name' =>  'Chí Linh', 'parent_code' =>  28, 'path_with_type' => 'Thị xã Chí Linh, Tỉnh Hải Dương', 'type' => 'thi-xa'],
        291 => ['id' => 291, 'name' =>  'Nam Sách', 'parent_code' =>  28, 'path_with_type' => 'Huyện Nam Sách, Tỉnh Hải Dương', 'type' => 'huyen'],
        292 => ['id' => 292, 'name' =>  'Kinh Môn', 'parent_code' =>  28, 'path_with_type' => 'Huyện Kinh Môn, Tỉnh Hải Dương', 'type' => 'huyen'],
        293 => ['id' => 293, 'name' =>  'Kim Thành', 'parent_code' =>  28, 'path_with_type' => 'Huyện Kim Thành, Tỉnh Hải Dương', 'type' => 'huyen'],
        294 => ['id' => 294, 'name' =>  'Thanh Hà', 'parent_code' =>  28, 'path_with_type' => 'Huyện Thanh Hà, Tỉnh Hải Dương', 'type' => 'huyen'],
        295 => ['id' => 295, 'name' =>  'Cẩm Giàng', 'parent_code' =>  28, 'path_with_type' => 'Huyện Cẩm Giàng, Tỉnh Hải Dương', 'type' => 'huyen'],
        296 => ['id' => 296, 'name' =>  'Bình Giang', 'parent_code' =>  28, 'path_with_type' => 'Huyện Bình Giang, Tỉnh Hải Dương', 'type' => 'huyen'],
        297 => ['id' => 297, 'name' =>  'Gia Lộc', 'parent_code' =>  28, 'path_with_type' => 'Huyện Gia Lộc, Tỉnh Hải Dương', 'type' => 'huyen'],
        298 => ['id' => 298, 'name' =>  'Tứ Kỳ', 'parent_code' =>  28, 'path_with_type' => 'Huyện Tứ Kỳ, Tỉnh Hải Dương', 'type' => 'huyen'],
        299 => ['id' => 299, 'name' =>  'Ninh Giang', 'parent_code' =>  28, 'path_with_type' => 'Huyện Ninh Giang, Tỉnh Hải Dương', 'type' => 'huyen'],
        300 => ['id' => 300, 'name' =>  'Thanh Miện', 'parent_code' =>  28, 'path_with_type' => 'Huyện Thanh Miện, Tỉnh Hải Dương', 'type' => 'huyen'],
        303 => ['id' => 303, 'name' =>  'Hồng Bàng', 'parent_code' =>  29, 'path_with_type' => 'Quận Hồng Bàng, Thành phố Hải Phòng', 'type' => 'quan'],
        304 => ['id' => 304, 'name' =>  'Ngô Quyền', 'parent_code' =>  29, 'path_with_type' => 'Quận Ngô Quyền, Thành phố Hải Phòng', 'type' => 'quan'],
        305 => ['id' => 305, 'name' =>  'Lê Chân', 'parent_code' =>  29, 'path_with_type' => 'Quận Lê Chân, Thành phố Hải Phòng', 'type' => 'quan'],
        306 => ['id' => 306, 'name' =>  'Hải An', 'parent_code' =>  29, 'path_with_type' => 'Quận Hải An, Thành phố Hải Phòng', 'type' => 'quan'],
        307 => ['id' => 307, 'name' =>  'Kiến An', 'parent_code' =>  29, 'path_with_type' => 'Quận Kiến An, Thành phố Hải Phòng', 'type' => 'quan'],
        308 => ['id' => 308, 'name' =>  'Đồ Sơn', 'parent_code' =>  29, 'path_with_type' => 'Quận Đồ Sơn, Thành phố Hải Phòng', 'type' => 'quan'],
        309 => ['id' => 309, 'name' =>  'Dương Kinh', 'parent_code' =>  29, 'path_with_type' => 'Quận Dương Kinh, Thành phố Hải Phòng', 'type' => 'quan'],
        311 => ['id' => 311, 'name' =>  'Thuỷ Nguyên', 'parent_code' =>  29, 'path_with_type' => 'Huyện Thuỷ Nguyên, Thành phố Hải Phòng', 'type' => 'huyen'],
        312 => ['id' => 312, 'name' =>  'An Dương', 'parent_code' =>  29, 'path_with_type' => 'Huyện An Dương, Thành phố Hải Phòng', 'type' => 'huyen'],
        313 => ['id' => 313, 'name' =>  'An Lão', 'parent_code' =>  29, 'path_with_type' => 'Huyện An Lão, Thành phố Hải Phòng', 'type' => 'huyen'],
        314 => ['id' => 314, 'name' =>  'Kiến Thuỵ', 'parent_code' =>  29, 'path_with_type' => 'Huyện Kiến Thuỵ, Thành phố Hải Phòng', 'type' => 'huyen'],
        315 => ['id' => 315, 'name' =>  'Tiên Lãng', 'parent_code' =>  29, 'path_with_type' => 'Huyện Tiên Lãng, Thành phố Hải Phòng', 'type' => 'huyen'],
        316 => ['id' => 316, 'name' =>  'Vĩnh Bảo', 'parent_code' =>  29, 'path_with_type' => 'Huyện Vĩnh Bảo, Thành phố Hải Phòng', 'type' => 'huyen'],
        317 => ['id' => 317, 'name' =>  'Cát Hải', 'parent_code' =>  29, 'path_with_type' => 'Huyện Cát Hải, Thành phố Hải Phòng', 'type' => 'huyen'],
        323 => ['id' => 323, 'name' =>  'Hưng Yên', 'parent_code' =>  32, 'path_with_type' => 'Thành phố Hưng Yên, Tỉnh Hưng Yên', 'type' => 'thanh-pho'],
        325 => ['id' => 325, 'name' =>  'Văn Lâm', 'parent_code' =>  32, 'path_with_type' => 'Huyện Văn Lâm, Tỉnh Hưng Yên', 'type' => 'huyen'],
        326 => ['id' => 326, 'name' =>  'Văn Giang', 'parent_code' =>  32, 'path_with_type' => 'Huyện Văn Giang, Tỉnh Hưng Yên', 'type' => 'huyen'],
        327 => ['id' => 327, 'name' =>  'Yên Mỹ', 'parent_code' =>  32, 'path_with_type' => 'Huyện Yên Mỹ, Tỉnh Hưng Yên', 'type' => 'huyen'],
        328 => ['id' => 328, 'name' =>  'Mỹ Hào', 'parent_code' =>  32, 'path_with_type' => 'Huyện Mỹ Hào, Tỉnh Hưng Yên', 'type' => 'huyen'],
        329 => ['id' => 329, 'name' =>  'Ân Thi', 'parent_code' =>  32, 'path_with_type' => 'Huyện Ân Thi, Tỉnh Hưng Yên', 'type' => 'huyen'],
        330 => ['id' => 330, 'name' =>  'Khoái Châu', 'parent_code' =>  32, 'path_with_type' => 'Huyện Khoái Châu, Tỉnh Hưng Yên', 'type' => 'huyen'],
        331 => ['id' => 331, 'name' =>  'Kim Động', 'parent_code' =>  32, 'path_with_type' => 'Huyện Kim Động, Tỉnh Hưng Yên', 'type' => 'huyen'],
        332 => ['id' => 332, 'name' =>  'Tiên Lữ', 'parent_code' =>  32, 'path_with_type' => 'Huyện Tiên Lữ, Tỉnh Hưng Yên', 'type' => 'huyen'],
        333 => ['id' => 333, 'name' =>  'Phù Cừ', 'parent_code' =>  32, 'path_with_type' => 'Huyện Phù Cừ, Tỉnh Hưng Yên', 'type' => 'huyen'],
        336 => ['id' => 336, 'name' =>  'Thái Bình', 'parent_code' =>  55, 'path_with_type' => 'Thành phố Thái Bình, Tỉnh Thái Bình', 'type' => 'thanh-pho'],
        338 => ['id' => 338, 'name' =>  'Quỳnh Phụ', 'parent_code' =>  55, 'path_with_type' => 'Huyện Quỳnh Phụ, Tỉnh Thái Bình', 'type' => 'huyen'],
        339 => ['id' => 339, 'name' =>  'Hưng Hà', 'parent_code' =>  55, 'path_with_type' => 'Huyện Hưng Hà, Tỉnh Thái Bình', 'type' => 'huyen'],
        340 => ['id' => 340, 'name' =>  'Đông Hưng', 'parent_code' =>  55, 'path_with_type' => 'Huyện Đông Hưng, Tỉnh Thái Bình', 'type' => 'huyen'],
        341 => ['id' => 341, 'name' =>  'Thái Thụy', 'parent_code' =>  55, 'path_with_type' => 'Huyện Thái Thụy, Tỉnh Thái Bình', 'type' => 'huyen'],
        342 => ['id' => 342, 'name' =>  'Tiền Hải', 'parent_code' =>  55, 'path_with_type' => 'Huyện Tiền Hải, Tỉnh Thái Bình', 'type' => 'huyen'],
        343 => ['id' => 343, 'name' =>  'Kiến Xương', 'parent_code' =>  55, 'path_with_type' => 'Huyện Kiến Xương, Tỉnh Thái Bình', 'type' => 'huyen'],
        344 => ['id' => 344, 'name' =>  'Vũ Thư', 'parent_code' =>  55, 'path_with_type' => 'Huyện Vũ Thư, Tỉnh Thái Bình', 'type' => 'huyen'],
        347 => ['id' => 347, 'name' =>  'Phủ Lý', 'parent_code' =>  25, 'path_with_type' => 'Thành phố Phủ Lý, Tỉnh Hà Nam', 'type' => 'thanh-pho'],
        349 => ['id' => 349, 'name' =>  'Duy Tiên', 'parent_code' =>  25, 'path_with_type' => 'Huyện Duy Tiên, Tỉnh Hà Nam', 'type' => 'huyen'],
        350 => ['id' => 350, 'name' =>  'Kim Bảng', 'parent_code' =>  25, 'path_with_type' => 'Huyện Kim Bảng, Tỉnh Hà Nam', 'type' => 'huyen'],
        351 => ['id' => 351, 'name' =>  'Thanh Liêm', 'parent_code' =>  25, 'path_with_type' => 'Huyện Thanh Liêm, Tỉnh Hà Nam', 'type' => 'huyen'],
        352 => ['id' => 352, 'name' =>  'Bình Lục', 'parent_code' =>  25, 'path_with_type' => 'Huyện Bình Lục, Tỉnh Hà Nam', 'type' => 'huyen'],
        353 => ['id' => 353, 'name' =>  'Lý Nhân', 'parent_code' =>  25, 'path_with_type' => 'Huyện Lý Nhân, Tỉnh Hà Nam', 'type' => 'huyen'],
        356 => ['id' => 356, 'name' =>  'Nam Định', 'parent_code' =>  41, 'path_with_type' => 'Thành phố Nam Định, Tỉnh Nam Định', 'type' => 'thanh-pho'],
        358 => ['id' => 358, 'name' =>  'Mỹ Lộc', 'parent_code' =>  41, 'path_with_type' => 'Huyện Mỹ Lộc, Tỉnh Nam Định', 'type' => 'huyen'],
        359 => ['id' => 359, 'name' =>  'Vụ Bản', 'parent_code' =>  41, 'path_with_type' => 'Huyện Vụ Bản, Tỉnh Nam Định', 'type' => 'huyen'],
        360 => ['id' => 360, 'name' =>  'Ý Yên', 'parent_code' =>  41, 'path_with_type' => 'Huyện Ý Yên, Tỉnh Nam Định', 'type' => 'huyen'],
        361 => ['id' => 361, 'name' =>  'Nghĩa Hưng', 'parent_code' =>  41, 'path_with_type' => 'Huyện Nghĩa Hưng, Tỉnh Nam Định', 'type' => 'huyen'],
        362 => ['id' => 362, 'name' =>  'Nam Trực', 'parent_code' =>  41, 'path_with_type' => 'Huyện Nam Trực, Tỉnh Nam Định', 'type' => 'huyen'],
        363 => ['id' => 363, 'name' =>  'Trực Ninh', 'parent_code' =>  41, 'path_with_type' => 'Huyện Trực Ninh, Tỉnh Nam Định', 'type' => 'huyen'],
        364 => ['id' => 364, 'name' =>  'Xuân Trường', 'parent_code' =>  41, 'path_with_type' => 'Huyện Xuân Trường, Tỉnh Nam Định', 'type' => 'huyen'],
        365 => ['id' => 365, 'name' =>  'Giao Thủy', 'parent_code' =>  41, 'path_with_type' => 'Huyện Giao Thủy, Tỉnh Nam Định', 'type' => 'huyen'],
        366 => ['id' => 366, 'name' =>  'Hải Hậu', 'parent_code' =>  41, 'path_with_type' => 'Huyện Hải Hậu, Tỉnh Nam Định', 'type' => 'huyen'],
        369 => ['id' => 369, 'name' =>  'Ninh Bình', 'parent_code' =>  43, 'path_with_type' => 'Thành phố Ninh Bình, Tỉnh Ninh Bình', 'type' => 'thanh-pho'],
        370 => ['id' => 370, 'name' =>  'Tam Điệp', 'parent_code' =>  43, 'path_with_type' => 'Thành phố Tam Điệp, Tỉnh Ninh Bình', 'type' => 'thanh-pho'],
        372 => ['id' => 372, 'name' =>  'Nho Quan', 'parent_code' =>  43, 'path_with_type' => 'Huyện Nho Quan, Tỉnh Ninh Bình', 'type' => 'huyen'],
        373 => ['id' => 373, 'name' =>  'Gia Viễn', 'parent_code' =>  43, 'path_with_type' => 'Huyện Gia Viễn, Tỉnh Ninh Bình', 'type' => 'huyen'],
        374 => ['id' => 374, 'name' =>  'Hoa Lư', 'parent_code' =>  43, 'path_with_type' => 'Huyện Hoa Lư, Tỉnh Ninh Bình', 'type' => 'huyen'],
        375 => ['id' => 375, 'name' =>  'Yên Khánh', 'parent_code' =>  43, 'path_with_type' => 'Huyện Yên Khánh, Tỉnh Ninh Bình', 'type' => 'huyen'],
        376 => ['id' => 376, 'name' =>  'Kim Sơn', 'parent_code' =>  43, 'path_with_type' => 'Huyện Kim Sơn, Tỉnh Ninh Bình', 'type' => 'huyen'],
        377 => ['id' => 377, 'name' =>  'Yên Mô', 'parent_code' =>  43, 'path_with_type' => 'Huyện Yên Mô, Tỉnh Ninh Bình', 'type' => 'huyen'],
        380 => ['id' => 380, 'name' =>  'Thanh Hóa', 'parent_code' =>  57, 'path_with_type' => 'Thành phố Thanh Hóa, Tỉnh Thanh Hóa', 'type' => 'thanh-pho'],
        381 => ['id' => 381, 'name' =>  'Bỉm Sơn', 'parent_code' =>  57, 'path_with_type' => 'Thị xã Bỉm Sơn, Tỉnh Thanh Hóa', 'type' => 'thi-xa'],
        382 => ['id' => 382, 'name' =>  'Sầm Sơn', 'parent_code' =>  57, 'path_with_type' => 'Thành phố Sầm Sơn, Tỉnh Thanh Hóa', 'type' => 'thanh-pho'],
        384 => ['id' => 384, 'name' =>  'Mường Lát', 'parent_code' =>  57, 'path_with_type' => 'Huyện Mường Lát, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        385 => ['id' => 385, 'name' =>  'Quan Hóa', 'parent_code' =>  57, 'path_with_type' => 'Huyện Quan Hóa, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        386 => ['id' => 386, 'name' =>  'Bá Thước', 'parent_code' =>  57, 'path_with_type' => 'Huyện Bá Thước, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        387 => ['id' => 387, 'name' =>  'Quan Sơn', 'parent_code' =>  57, 'path_with_type' => 'Huyện Quan Sơn, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        388 => ['id' => 388, 'name' =>  'Lang Chánh', 'parent_code' =>  57, 'path_with_type' => 'Huyện Lang Chánh, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        389 => ['id' => 389, 'name' =>  'Ngọc Lặc', 'parent_code' =>  57, 'path_with_type' => 'Huyện Ngọc Lặc, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        390 => ['id' => 390, 'name' =>  'Cẩm Thủy', 'parent_code' =>  57, 'path_with_type' => 'Huyện Cẩm Thủy, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        391 => ['id' => 391, 'name' =>  'Thạch Thành', 'parent_code' =>  57, 'path_with_type' => 'Huyện Thạch Thành, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        392 => ['id' => 392, 'name' =>  'Hà Trung', 'parent_code' =>  57, 'path_with_type' => 'Huyện Hà Trung, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        393 => ['id' => 393, 'name' =>  'Vĩnh Lộc', 'parent_code' =>  57, 'path_with_type' => 'Huyện Vĩnh Lộc, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        394 => ['id' => 394, 'name' =>  'Yên Định', 'parent_code' =>  57, 'path_with_type' => 'Huyện Yên Định, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        395 => ['id' => 395, 'name' =>  'Thọ Xuân', 'parent_code' =>  57, 'path_with_type' => 'Huyện Thọ Xuân, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        396 => ['id' => 396, 'name' =>  'Thường Xuân', 'parent_code' =>  57, 'path_with_type' => 'Huyện Thường Xuân, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        397 => ['id' => 397, 'name' =>  'Triệu Sơn', 'parent_code' =>  57, 'path_with_type' => 'Huyện Triệu Sơn, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        398 => ['id' => 398, 'name' =>  'Thiệu Hóa', 'parent_code' =>  57, 'path_with_type' => 'Huyện Thiệu Hóa, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        399 => ['id' => 399, 'name' =>  'Hoằng Hóa', 'parent_code' =>  57, 'path_with_type' => 'Huyện Hoằng Hóa, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        400 => ['id' => 400, 'name' =>  'Hậu Lộc', 'parent_code' =>  57, 'path_with_type' => 'Huyện Hậu Lộc, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        401 => ['id' => 401, 'name' =>  'Nga Sơn', 'parent_code' =>  57, 'path_with_type' => 'Huyện Nga Sơn, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        402 => ['id' => 402, 'name' =>  'Như Xuân', 'parent_code' =>  57, 'path_with_type' => 'Huyện Như Xuân, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        403 => ['id' => 403, 'name' =>  'Như Thanh', 'parent_code' =>  57, 'path_with_type' => 'Huyện Như Thanh, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        404 => ['id' => 404, 'name' =>  'Nông Cống', 'parent_code' =>  57, 'path_with_type' => 'Huyện Nông Cống, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        405 => ['id' => 405, 'name' =>  'Đông Sơn', 'parent_code' =>  57, 'path_with_type' => 'Huyện Đông Sơn, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        406 => ['id' => 406, 'name' =>  'Quảng Xương', 'parent_code' =>  57, 'path_with_type' => 'Huyện Quảng Xương, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        407 => ['id' => 407, 'name' =>  'Tĩnh Gia', 'parent_code' =>  57, 'path_with_type' => 'Huyện Tĩnh Gia, Tỉnh Thanh Hóa', 'type' => 'huyen'],
        412 => ['id' => 412, 'name' =>  'Vinh', 'parent_code' =>  42, 'path_with_type' => 'Thành phố Vinh, Tỉnh Nghệ An', 'type' => 'thanh-pho'],
        413 => ['id' => 413, 'name' =>  'Cửa Lò', 'parent_code' =>  42, 'path_with_type' => 'Thị xã Cửa Lò, Tỉnh Nghệ An', 'type' => 'thi-xa'],
        414 => ['id' => 414, 'name' =>  'Thái Hoà', 'parent_code' =>  42, 'path_with_type' => 'Thị xã Thái Hoà, Tỉnh Nghệ An', 'type' => 'thi-xa'],
        415 => ['id' => 415, 'name' =>  'Quế Phong', 'parent_code' =>  42, 'path_with_type' => 'Huyện Quế Phong, Tỉnh Nghệ An', 'type' => 'huyen'],
        416 => ['id' => 416, 'name' =>  'Quỳ Châu', 'parent_code' =>  42, 'path_with_type' => 'Huyện Quỳ Châu, Tỉnh Nghệ An', 'type' => 'huyen'],
        417 => ['id' => 417, 'name' =>  'Kỳ Sơn', 'parent_code' =>  42, 'path_with_type' => 'Huyện Kỳ Sơn, Tỉnh Nghệ An', 'type' => 'huyen'],
        418 => ['id' => 418, 'name' =>  'Tương Dương', 'parent_code' =>  42, 'path_with_type' => 'Huyện Tương Dương, Tỉnh Nghệ An', 'type' => 'huyen'],
        419 => ['id' => 419, 'name' =>  'Nghĩa Đàn', 'parent_code' =>  42, 'path_with_type' => 'Huyện Nghĩa Đàn, Tỉnh Nghệ An', 'type' => 'huyen'],
        420 => ['id' => 420, 'name' =>  'Quỳ Hợp', 'parent_code' =>  42, 'path_with_type' => 'Huyện Quỳ Hợp, Tỉnh Nghệ An', 'type' => 'huyen'],
        421 => ['id' => 421, 'name' =>  'Quỳnh Lưu', 'parent_code' =>  42, 'path_with_type' => 'Huyện Quỳnh Lưu, Tỉnh Nghệ An', 'type' => 'huyen'],
        422 => ['id' => 422, 'name' =>  'Con Cuông', 'parent_code' =>  42, 'path_with_type' => 'Huyện Con Cuông, Tỉnh Nghệ An', 'type' => 'huyen'],
        423 => ['id' => 423, 'name' =>  'Tân Kỳ', 'parent_code' =>  42, 'path_with_type' => 'Huyện Tân Kỳ, Tỉnh Nghệ An', 'type' => 'huyen'],
        424 => ['id' => 424, 'name' =>  'Anh Sơn', 'parent_code' =>  42, 'path_with_type' => 'Huyện Anh Sơn, Tỉnh Nghệ An', 'type' => 'huyen'],
        425 => ['id' => 425, 'name' =>  'Diễn Châu', 'parent_code' =>  42, 'path_with_type' => 'Huyện Diễn Châu, Tỉnh Nghệ An', 'type' => 'huyen'],
        426 => ['id' => 426, 'name' =>  'Yên Thành', 'parent_code' =>  42, 'path_with_type' => 'Huyện Yên Thành, Tỉnh Nghệ An', 'type' => 'huyen'],
        427 => ['id' => 427, 'name' =>  'Đô Lương', 'parent_code' =>  42, 'path_with_type' => 'Huyện Đô Lương, Tỉnh Nghệ An', 'type' => 'huyen'],
        428 => ['id' => 428, 'name' =>  'Thanh Chương', 'parent_code' =>  42, 'path_with_type' => 'Huyện Thanh Chương, Tỉnh Nghệ An', 'type' => 'huyen'],
        429 => ['id' => 429, 'name' =>  'Nghi Lộc', 'parent_code' =>  42, 'path_with_type' => 'Huyện Nghi Lộc, Tỉnh Nghệ An', 'type' => 'huyen'],
        430 => ['id' => 430, 'name' =>  'Nam Đàn', 'parent_code' =>  42, 'path_with_type' => 'Huyện Nam Đàn, Tỉnh Nghệ An', 'type' => 'huyen'],
        431 => ['id' => 431, 'name' =>  'Hưng Nguyên', 'parent_code' =>  42, 'path_with_type' => 'Huyện Hưng Nguyên, Tỉnh Nghệ An', 'type' => 'huyen'],
        432 => ['id' => 432, 'name' =>  'Hoàng Mai', 'parent_code' =>  42, 'path_with_type' => 'Thị xã Hoàng Mai, Tỉnh Nghệ An', 'type' => 'thi-xa'],
        436 => ['id' => 436, 'name' =>  'Hà Tĩnh', 'parent_code' =>  27, 'path_with_type' => 'Thành phố Hà Tĩnh, Tỉnh Hà Tĩnh', 'type' => 'thanh-pho'],
        437 => ['id' => 437, 'name' =>  'Hồng Lĩnh', 'parent_code' =>  27, 'path_with_type' => 'Thị xã Hồng Lĩnh, Tỉnh Hà Tĩnh', 'type' => 'thi-xa'],
        439 => ['id' => 439, 'name' =>  'Hương Sơn', 'parent_code' =>  27, 'path_with_type' => 'Huyện Hương Sơn, Tỉnh Hà Tĩnh', 'type' => 'huyen'],
        440 => ['id' => 440, 'name' =>  'Đức Thọ', 'parent_code' =>  27, 'path_with_type' => 'Huyện Đức Thọ, Tỉnh Hà Tĩnh', 'type' => 'huyen'],
        441 => ['id' => 441, 'name' =>  'Vũ Quang', 'parent_code' =>  27, 'path_with_type' => 'Huyện Vũ Quang, Tỉnh Hà Tĩnh', 'type' => 'huyen'],
        442 => ['id' => 442, 'name' =>  'Nghi Xuân', 'parent_code' =>  27, 'path_with_type' => 'Huyện Nghi Xuân, Tỉnh Hà Tĩnh', 'type' => 'huyen'],
        443 => ['id' => 443, 'name' =>  'Can Lộc', 'parent_code' =>  27, 'path_with_type' => 'Huyện Can Lộc, Tỉnh Hà Tĩnh', 'type' => 'huyen'],
        444 => ['id' => 444, 'name' =>  'Hương Khê', 'parent_code' =>  27, 'path_with_type' => 'Huyện Hương Khê, Tỉnh Hà Tĩnh', 'type' => 'huyen'],
        445 => ['id' => 445, 'name' =>  'Thạch Hà', 'parent_code' =>  27, 'path_with_type' => 'Huyện Thạch Hà, Tỉnh Hà Tĩnh', 'type' => 'huyen'],
        446 => ['id' => 446, 'name' =>  'Cẩm Xuyên', 'parent_code' =>  27, 'path_with_type' => 'Huyện Cẩm Xuyên, Tỉnh Hà Tĩnh', 'type' => 'huyen'],
        447 => ['id' => 447, 'name' =>  'Kỳ Anh', 'parent_code' =>  27, 'path_with_type' => 'Huyện Kỳ Anh, Tỉnh Hà Tĩnh', 'type' => 'huyen'],
        448 => ['id' => 448, 'name' =>  'Lộc Hà', 'parent_code' =>  27, 'path_with_type' => 'Huyện Lộc Hà, Tỉnh Hà Tĩnh', 'type' => 'huyen'],
        449 => ['id' => 449, 'name' =>  'Kỳ Anh', 'parent_code' =>  27, 'path_with_type' => 'Thị xã Kỳ Anh, Tỉnh Hà Tĩnh', 'type' => 'thi-xa'],
        450 => ['id' => 450, 'name' =>  'Đồng Hới', 'parent_code' =>  47, 'path_with_type' => 'Thành Phố Đồng Hới, Tỉnh Quảng Bình', 'type' => 'thanh-pho'],
        452 => ['id' => 452, 'name' =>  'Minh Hóa', 'parent_code' =>  47, 'path_with_type' => 'Huyện Minh Hóa, Tỉnh Quảng Bình', 'type' => 'huyen'],
        453 => ['id' => 453, 'name' =>  'Tuyên Hóa', 'parent_code' =>  47, 'path_with_type' => 'Huyện Tuyên Hóa, Tỉnh Quảng Bình', 'type' => 'huyen'],
        454 => ['id' => 454, 'name' =>  'Quảng Trạch', 'parent_code' =>  47, 'path_with_type' => 'Huyện Quảng Trạch, Tỉnh Quảng Bình', 'type' => 'huyen'],
        455 => ['id' => 455, 'name' =>  'Bố Trạch', 'parent_code' =>  47, 'path_with_type' => 'Huyện Bố Trạch, Tỉnh Quảng Bình', 'type' => 'huyen'],
        456 => ['id' => 456, 'name' =>  'Quảng Ninh', 'parent_code' =>  47, 'path_with_type' => 'Huyện Quảng Ninh, Tỉnh Quảng Bình', 'type' => 'huyen'],
        457 => ['id' => 457, 'name' =>  'Lệ Thủy', 'parent_code' =>  47, 'path_with_type' => 'Huyện Lệ Thủy, Tỉnh Quảng Bình', 'type' => 'huyen'],
        458 => ['id' => 458, 'name' =>  'Ba Đồn', 'parent_code' =>  47, 'path_with_type' => 'Thị xã Ba Đồn, Tỉnh Quảng Bình', 'type' => 'thi-xa'],
        461 => ['id' => 461, 'name' =>  'Đông Hà', 'parent_code' =>  51, 'path_with_type' => 'Thành phố Đông Hà, Tỉnh Quảng Trị', 'type' => 'thanh-pho'],
        462 => ['id' => 462, 'name' =>  'Quảng Trị', 'parent_code' =>  51, 'path_with_type' => 'Thị xã Quảng Trị, Tỉnh Quảng Trị', 'type' => 'thi-xa'],
        464 => ['id' => 464, 'name' =>  'Vĩnh Linh', 'parent_code' =>  51, 'path_with_type' => 'Huyện Vĩnh Linh, Tỉnh Quảng Trị', 'type' => 'huyen'],
        465 => ['id' => 465, 'name' =>  'Hướng Hóa', 'parent_code' =>  51, 'path_with_type' => 'Huyện Hướng Hóa, Tỉnh Quảng Trị', 'type' => 'huyen'],
        466 => ['id' => 466, 'name' =>  'Gio Linh', 'parent_code' =>  51, 'path_with_type' => 'Huyện Gio Linh, Tỉnh Quảng Trị', 'type' => 'huyen'],
        467 => ['id' => 467, 'name' =>  'Đa Krông', 'parent_code' =>  51, 'path_with_type' => 'Huyện Đa Krông, Tỉnh Quảng Trị', 'type' => 'huyen'],
        468 => ['id' => 468, 'name' =>  'Cam Lộ', 'parent_code' =>  51, 'path_with_type' => 'Huyện Cam Lộ, Tỉnh Quảng Trị', 'type' => 'huyen'],
        469 => ['id' => 469, 'name' =>  'Triệu Phong', 'parent_code' =>  51, 'path_with_type' => 'Huyện Triệu Phong, Tỉnh Quảng Trị', 'type' => 'huyen'],
        470 => ['id' => 470, 'name' =>  'Hải Lăng', 'parent_code' =>  51, 'path_with_type' => 'Huyện Hải Lăng, Tỉnh Quảng Trị', 'type' => 'huyen'],
        474 => ['id' => 474, 'name' =>  'Huế', 'parent_code' =>  58, 'path_with_type' => 'Thành phố Huế, Tỉnh Thừa Thiên Huế', 'type' => 'thanh-pho'],
        476 => ['id' => 476, 'name' =>  'Phong Điền', 'parent_code' =>  58, 'path_with_type' => 'Huyện Phong Điền, Tỉnh Thừa Thiên Huế', 'type' => 'huyen'],
        477 => ['id' => 477, 'name' =>  'Quảng Điền', 'parent_code' =>  58, 'path_with_type' => 'Huyện Quảng Điền, Tỉnh Thừa Thiên Huế', 'type' => 'huyen'],
        478 => ['id' => 478, 'name' =>  'Phú Vang', 'parent_code' =>  58, 'path_with_type' => 'Huyện Phú Vang, Tỉnh Thừa Thiên Huế', 'type' => 'huyen'],
        479 => ['id' => 479, 'name' =>  'Hương Thủy', 'parent_code' =>  58, 'path_with_type' => 'Thị xã Hương Thủy, Tỉnh Thừa Thiên Huế', 'type' => 'thi-xa'],
        480 => ['id' => 480, 'name' =>  'Hương Trà', 'parent_code' =>  58, 'path_with_type' => 'Thị xã Hương Trà, Tỉnh Thừa Thiên Huế', 'type' => 'thi-xa'],
        481 => ['id' => 481, 'name' =>  'A Lưới', 'parent_code' =>  58, 'path_with_type' => 'Huyện A Lưới, Tỉnh Thừa Thiên Huế', 'type' => 'huyen'],
        482 => ['id' => 482, 'name' =>  'Phú Lộc', 'parent_code' =>  58, 'path_with_type' => 'Huyện Phú Lộc, Tỉnh Thừa Thiên Huế', 'type' => 'huyen'],
        483 => ['id' => 483, 'name' =>  'Nam Đông', 'parent_code' =>  58, 'path_with_type' => 'Huyện Nam Đông, Tỉnh Thừa Thiên Huế', 'type' => 'huyen'],
        490 => ['id' => 490, 'name' =>  'Liên Chiểu', 'parent_code' =>  17, 'path_with_type' => 'Quận Liên Chiểu, Thành phố Đà Nẵng', 'type' => 'quan'],
        491 => ['id' => 491, 'name' =>  'Thanh Khê', 'parent_code' =>  17, 'path_with_type' => 'Quận Thanh Khê, Thành phố Đà Nẵng', 'type' => 'quan'],
        492 => ['id' => 492, 'name' =>  'Hải Châu', 'parent_code' =>  17, 'path_with_type' => 'Quận Hải Châu, Thành phố Đà Nẵng', 'type' => 'quan'],
        493 => ['id' => 493, 'name' =>  'Sơn Trà', 'parent_code' =>  17, 'path_with_type' => 'Quận Sơn Trà, Thành phố Đà Nẵng', 'type' => 'quan'],
        494 => ['id' => 494, 'name' =>  'Ngũ Hành Sơn', 'parent_code' =>  17, 'path_with_type' => 'Quận Ngũ Hành Sơn, Thành phố Đà Nẵng', 'type' => 'quan'],
        495 => ['id' => 495, 'name' =>  'Cẩm Lệ', 'parent_code' =>  17, 'path_with_type' => 'Quận Cẩm Lệ, Thành phố Đà Nẵng', 'type' => 'quan'],
        497 => ['id' => 497, 'name' =>  'Hòa Vang', 'parent_code' =>  17, 'path_with_type' => 'Huyện Hòa Vang, Thành phố Đà Nẵng', 'type' => 'huyen'],
        502 => ['id' => 502, 'name' =>  'Tam Kỳ', 'parent_code' =>  48, 'path_with_type' => 'Thành phố Tam Kỳ, Tỉnh Quảng Nam', 'type' => 'thanh-pho'],
        503 => ['id' => 503, 'name' =>  'Hội An', 'parent_code' =>  48, 'path_with_type' => 'Thành phố Hội An, Tỉnh Quảng Nam', 'type' => 'thanh-pho'],
        504 => ['id' => 504, 'name' =>  'Tây Giang', 'parent_code' =>  48, 'path_with_type' => 'Huyện Tây Giang, Tỉnh Quảng Nam', 'type' => 'huyen'],
        505 => ['id' => 505, 'name' =>  'Đông Giang', 'parent_code' =>  48, 'path_with_type' => 'Huyện Đông Giang, Tỉnh Quảng Nam', 'type' => 'huyen'],
        506 => ['id' => 506, 'name' =>  'Đại Lộc', 'parent_code' =>  48, 'path_with_type' => 'Huyện Đại Lộc, Tỉnh Quảng Nam', 'type' => 'huyen'],
        507 => ['id' => 507, 'name' =>  'Điện Bàn', 'parent_code' =>  48, 'path_with_type' => 'Thị xã Điện Bàn, Tỉnh Quảng Nam', 'type' => 'thi-xa'],
        508 => ['id' => 508, 'name' =>  'Duy Xuyên', 'parent_code' =>  48, 'path_with_type' => 'Huyện Duy Xuyên, Tỉnh Quảng Nam', 'type' => 'huyen'],
        509 => ['id' => 509, 'name' =>  'Quế Sơn', 'parent_code' =>  48, 'path_with_type' => 'Huyện Quế Sơn, Tỉnh Quảng Nam', 'type' => 'huyen'],
        510 => ['id' => 510, 'name' =>  'Nam Giang', 'parent_code' =>  48, 'path_with_type' => 'Huyện Nam Giang, Tỉnh Quảng Nam', 'type' => 'huyen'],
        511 => ['id' => 511, 'name' =>  'Phước Sơn', 'parent_code' =>  48, 'path_with_type' => 'Huyện Phước Sơn, Tỉnh Quảng Nam', 'type' => 'huyen'],
        512 => ['id' => 512, 'name' =>  'Hiệp Đức', 'parent_code' =>  48, 'path_with_type' => 'Huyện Hiệp Đức, Tỉnh Quảng Nam', 'type' => 'huyen'],
        513 => ['id' => 513, 'name' =>  'Thăng Bình', 'parent_code' =>  48, 'path_with_type' => 'Huyện Thăng Bình, Tỉnh Quảng Nam', 'type' => 'huyen'],
        514 => ['id' => 514, 'name' =>  'Tiên Phước', 'parent_code' =>  48, 'path_with_type' => 'Huyện Tiên Phước, Tỉnh Quảng Nam', 'type' => 'huyen'],
        515 => ['id' => 515, 'name' =>  'Bắc Trà My', 'parent_code' =>  48, 'path_with_type' => 'Huyện Bắc Trà My, Tỉnh Quảng Nam', 'type' => 'huyen'],
        516 => ['id' => 516, 'name' =>  'Nam Trà My', 'parent_code' =>  48, 'path_with_type' => 'Huyện Nam Trà My, Tỉnh Quảng Nam', 'type' => 'huyen'],
        517 => ['id' => 517, 'name' =>  'Núi Thành', 'parent_code' =>  48, 'path_with_type' => 'Huyện Núi Thành, Tỉnh Quảng Nam', 'type' => 'huyen'],
        518 => ['id' => 518, 'name' =>  'Phú Ninh', 'parent_code' =>  48, 'path_with_type' => 'Huyện Phú Ninh, Tỉnh Quảng Nam', 'type' => 'huyen'],
        519 => ['id' => 519, 'name' =>  'Nông Sơn', 'parent_code' =>  48, 'path_with_type' => 'Huyện Nông Sơn, Tỉnh Quảng Nam', 'type' => 'huyen'],
        522 => ['id' => 522, 'name' =>  'Quảng Ngãi', 'parent_code' =>  49, 'path_with_type' => 'Thành phố Quảng Ngãi, Tỉnh Quảng Ngãi', 'type' => 'thanh-pho'],
        524 => ['id' => 524, 'name' =>  'Bình Sơn', 'parent_code' =>  49, 'path_with_type' => 'Huyện Bình Sơn, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        525 => ['id' => 525, 'name' =>  'Trà Bồng', 'parent_code' =>  49, 'path_with_type' => 'Huyện Trà Bồng, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        526 => ['id' => 526, 'name' =>  'Tây Trà', 'parent_code' =>  49, 'path_with_type' => 'Huyện Tây Trà, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        527 => ['id' => 527, 'name' =>  'Sơn Tịnh', 'parent_code' =>  49, 'path_with_type' => 'Huyện Sơn Tịnh, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        528 => ['id' => 528, 'name' =>  'Tư Nghĩa', 'parent_code' =>  49, 'path_with_type' => 'Huyện Tư Nghĩa, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        529 => ['id' => 529, 'name' =>  'Sơn Hà', 'parent_code' =>  49, 'path_with_type' => 'Huyện Sơn Hà, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        530 => ['id' => 530, 'name' =>  'Sơn Tây', 'parent_code' =>  49, 'path_with_type' => 'Huyện Sơn Tây, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        531 => ['id' => 531, 'name' =>  'Minh Long', 'parent_code' =>  49, 'path_with_type' => 'Huyện Minh Long, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        532 => ['id' => 532, 'name' =>  'Nghĩa Hành', 'parent_code' =>  49, 'path_with_type' => 'Huyện Nghĩa Hành, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        533 => ['id' => 533, 'name' =>  'Mộ Đức', 'parent_code' =>  49, 'path_with_type' => 'Huyện Mộ Đức, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        534 => ['id' => 534, 'name' =>  'Đức Phổ', 'parent_code' =>  49, 'path_with_type' => 'Huyện Đức Phổ, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        535 => ['id' => 535, 'name' =>  'Ba Tơ', 'parent_code' =>  49, 'path_with_type' => 'Huyện Ba Tơ, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        536 => ['id' => 536, 'name' =>  'Lý Sơn', 'parent_code' =>  49, 'path_with_type' => 'Huyện Lý Sơn, Tỉnh Quảng Ngãi', 'type' => 'huyen'],
        540 => ['id' => 540, 'name' =>  'Qui Nhơn', 'parent_code' =>  11, 'path_with_type' => 'Thành phố Qui Nhơn, Tỉnh Bình Định', 'type' => 'thanh-pho'],
        542 => ['id' => 542, 'name' =>  'An Lão', 'parent_code' =>  11, 'path_with_type' => 'Huyện An Lão, Tỉnh Bình Định', 'type' => 'huyen'],
        543 => ['id' => 543, 'name' =>  'Hoài Nhơn', 'parent_code' =>  11, 'path_with_type' => 'Huyện Hoài Nhơn, Tỉnh Bình Định', 'type' => 'huyen'],
        544 => ['id' => 544, 'name' =>  'Hoài Ân', 'parent_code' =>  11, 'path_with_type' => 'Huyện Hoài Ân, Tỉnh Bình Định', 'type' => 'huyen'],
        545 => ['id' => 545, 'name' =>  'Phù Mỹ', 'parent_code' =>  11, 'path_with_type' => 'Huyện Phù Mỹ, Tỉnh Bình Định', 'type' => 'huyen'],
        546 => ['id' => 546, 'name' =>  'Vĩnh Thạnh', 'parent_code' =>  11, 'path_with_type' => 'Huyện Vĩnh Thạnh, Tỉnh Bình Định', 'type' => 'huyen'],
        547 => ['id' => 547, 'name' =>  'Tây Sơn', 'parent_code' =>  11, 'path_with_type' => 'Huyện Tây Sơn, Tỉnh Bình Định', 'type' => 'huyen'],
        548 => ['id' => 548, 'name' =>  'Phù Cát', 'parent_code' =>  11, 'path_with_type' => 'Huyện Phù Cát, Tỉnh Bình Định', 'type' => 'huyen'],
        549 => ['id' => 549, 'name' =>  'An Nhơn', 'parent_code' =>  11, 'path_with_type' => 'Thị xã An Nhơn, Tỉnh Bình Định', 'type' => 'thi-xa'],
        550 => ['id' => 550, 'name' =>  'Tuy Phước', 'parent_code' =>  11, 'path_with_type' => 'Huyện Tuy Phước, Tỉnh Bình Định', 'type' => 'huyen'],
        551 => ['id' => 551, 'name' =>  'Vân Canh', 'parent_code' =>  11, 'path_with_type' => 'Huyện Vân Canh, Tỉnh Bình Định', 'type' => 'huyen'],
        555 => ['id' => 555, 'name' =>  'Tuy Hoà', 'parent_code' =>  46, 'path_with_type' => 'Thành phố Tuy Hoà, Tỉnh Phú Yên', 'type' => 'thanh-pho'],
        557 => ['id' => 557, 'name' =>  'Sông Cầu', 'parent_code' =>  46, 'path_with_type' => 'Thị xã Sông Cầu, Tỉnh Phú Yên', 'type' => 'thi-xa'],
        558 => ['id' => 558, 'name' =>  'Đồng Xuân', 'parent_code' =>  46, 'path_with_type' => 'Huyện Đồng Xuân, Tỉnh Phú Yên', 'type' => 'huyen'],
        559 => ['id' => 559, 'name' =>  'Tuy An', 'parent_code' =>  46, 'path_with_type' => 'Huyện Tuy An, Tỉnh Phú Yên', 'type' => 'huyen'],
        560 => ['id' => 560, 'name' =>  'Sơn Hòa', 'parent_code' =>  46, 'path_with_type' => 'Huyện Sơn Hòa, Tỉnh Phú Yên', 'type' => 'huyen'],
        561 => ['id' => 561, 'name' =>  'Sông Hinh', 'parent_code' =>  46, 'path_with_type' => 'Huyện Sông Hinh, Tỉnh Phú Yên', 'type' => 'huyen'],
        562 => ['id' => 562, 'name' =>  'Tây Hoà', 'parent_code' =>  46, 'path_with_type' => 'Huyện Tây Hoà, Tỉnh Phú Yên', 'type' => 'huyen'],
        563 => ['id' => 563, 'name' =>  'Phú Hoà', 'parent_code' =>  46, 'path_with_type' => 'Huyện Phú Hoà, Tỉnh Phú Yên', 'type' => 'huyen'],
        564 => ['id' => 564, 'name' =>  'Đông Hòa', 'parent_code' =>  46, 'path_with_type' => 'Huyện Đông Hòa, Tỉnh Phú Yên', 'type' => 'huyen'],
        568 => ['id' => 568, 'name' =>  'Nha Trang', 'parent_code' =>  33, 'path_with_type' => 'Thành phố Nha Trang, Tỉnh Khánh Hòa', 'type' => 'thanh-pho'],
        569 => ['id' => 569, 'name' =>  'Cam Ranh', 'parent_code' =>  33, 'path_with_type' => 'Thành phố Cam Ranh, Tỉnh Khánh Hòa', 'type' => 'thanh-pho'],
        570 => ['id' => 570, 'name' =>  'Cam Lâm', 'parent_code' =>  33, 'path_with_type' => 'Huyện Cam Lâm, Tỉnh Khánh Hòa', 'type' => 'huyen'],
        571 => ['id' => 571, 'name' =>  'Vạn Ninh', 'parent_code' =>  33, 'path_with_type' => 'Huyện Vạn Ninh, Tỉnh Khánh Hòa', 'type' => 'huyen'],
        572 => ['id' => 572, 'name' =>  'Ninh Hòa', 'parent_code' =>  33, 'path_with_type' => 'Thị xã Ninh Hòa, Tỉnh Khánh Hòa', 'type' => 'thi-xa'],
        573 => ['id' => 573, 'name' =>  'Khánh Vĩnh', 'parent_code' =>  33, 'path_with_type' => 'Huyện Khánh Vĩnh, Tỉnh Khánh Hòa', 'type' => 'huyen'],
        574 => ['id' => 574, 'name' =>  'Diên Khánh', 'parent_code' =>  33, 'path_with_type' => 'Huyện Diên Khánh, Tỉnh Khánh Hòa', 'type' => 'huyen'],
        575 => ['id' => 575, 'name' =>  'Khánh Sơn', 'parent_code' =>  33, 'path_with_type' => 'Huyện Khánh Sơn, Tỉnh Khánh Hòa', 'type' => 'huyen'],
        576 => ['id' => 576, 'name' =>  'Trường Sa', 'parent_code' =>  33, 'path_with_type' => 'Huyện Trường Sa, Tỉnh Khánh Hòa', 'type' => 'huyen'],
        582 => ['id' => 582, 'name' =>  'Phan Rang-Tháp Chàm', 'parent_code' =>  44, 'path_with_type' => 'Thành phố Phan Rang-Tháp Chàm, Tỉnh Ninh Thuận', 'type' => 'thanh-pho'],
        584 => ['id' => 584, 'name' =>  'Bác Ái', 'parent_code' =>  44, 'path_with_type' => 'Huyện Bác Ái, Tỉnh Ninh Thuận', 'type' => 'huyen'],
        585 => ['id' => 585, 'name' =>  'Ninh Sơn', 'parent_code' =>  44, 'path_with_type' => 'Huyện Ninh Sơn, Tỉnh Ninh Thuận', 'type' => 'huyen'],
        586 => ['id' => 586, 'name' =>  'Ninh Hải', 'parent_code' =>  44, 'path_with_type' => 'Huyện Ninh Hải, Tỉnh Ninh Thuận', 'type' => 'huyen'],
        587 => ['id' => 587, 'name' =>  'Ninh Phước', 'parent_code' =>  44, 'path_with_type' => 'Huyện Ninh Phước, Tỉnh Ninh Thuận', 'type' => 'huyen'],
        588 => ['id' => 588, 'name' =>  'Thuận Bắc', 'parent_code' =>  44, 'path_with_type' => 'Huyện Thuận Bắc, Tỉnh Ninh Thuận', 'type' => 'huyen'],
        589 => ['id' => 589, 'name' =>  'Thuận Nam', 'parent_code' =>  44, 'path_with_type' => 'Huyện Thuận Nam, Tỉnh Ninh Thuận', 'type' => 'huyen'],
        593 => ['id' => 593, 'name' =>  'Phan Thiết', 'parent_code' =>  13, 'path_with_type' => 'Thành phố Phan Thiết, Tỉnh Bình Thuận', 'type' => 'thanh-pho'],
        594 => ['id' => 594, 'name' =>  'La Gi', 'parent_code' =>  13, 'path_with_type' => 'Thị xã La Gi, Tỉnh Bình Thuận', 'type' => 'thi-xa'],
        595 => ['id' => 595, 'name' =>  'Tuy Phong', 'parent_code' =>  13, 'path_with_type' => 'Huyện Tuy Phong, Tỉnh Bình Thuận', 'type' => 'huyen'],
        596 => ['id' => 596, 'name' =>  'Bắc Bình', 'parent_code' =>  13, 'path_with_type' => 'Huyện Bắc Bình, Tỉnh Bình Thuận', 'type' => 'huyen'],
        597 => ['id' => 597, 'name' =>  'Hàm Thuận Bắc', 'parent_code' =>  13, 'path_with_type' => 'Huyện Hàm Thuận Bắc, Tỉnh Bình Thuận', 'type' => 'huyen'],
        598 => ['id' => 598, 'name' =>  'Hàm Thuận Nam', 'parent_code' =>  13, 'path_with_type' => 'Huyện Hàm Thuận Nam, Tỉnh Bình Thuận', 'type' => 'huyen'],
        599 => ['id' => 599, 'name' =>  'Tánh Linh', 'parent_code' =>  13, 'path_with_type' => 'Huyện Tánh Linh, Tỉnh Bình Thuận', 'type' => 'huyen'],
        600 => ['id' => 600, 'name' =>  'Đức Linh', 'parent_code' =>  13, 'path_with_type' => 'Huyện Đức Linh, Tỉnh Bình Thuận', 'type' => 'huyen'],
        601 => ['id' => 601, 'name' =>  'Hàm Tân', 'parent_code' =>  13, 'path_with_type' => 'Huyện Hàm Tân, Tỉnh Bình Thuận', 'type' => 'huyen'],
        602 => ['id' => 602, 'name' =>  'Phú Quí', 'parent_code' =>  13, 'path_with_type' => 'Huyện Phú Quí, Tỉnh Bình Thuận', 'type' => 'huyen'],
        608 => ['id' => 608, 'name' =>  'Kon Tum', 'parent_code' =>  35, 'path_with_type' => 'Thành phố Kon Tum, Tỉnh Kon Tum', 'type' => 'thanh-pho'],
        610 => ['id' => 610, 'name' =>  'Đắk Glei', 'parent_code' =>  35, 'path_with_type' => 'Huyện Đắk Glei, Tỉnh Kon Tum', 'type' => 'huyen'],
        611 => ['id' => 611, 'name' =>  'Ngọc Hồi', 'parent_code' =>  35, 'path_with_type' => 'Huyện Ngọc Hồi, Tỉnh Kon Tum', 'type' => 'huyen'],
        612 => ['id' => 612, 'name' =>  'Đắk Tô', 'parent_code' =>  35, 'path_with_type' => 'Huyện Đắk Tô, Tỉnh Kon Tum', 'type' => 'huyen'],
        613 => ['id' => 613, 'name' =>  'Kon Plông', 'parent_code' =>  35, 'path_with_type' => 'Huyện Kon Plông, Tỉnh Kon Tum', 'type' => 'huyen'],
        614 => ['id' => 614, 'name' =>  'Kon Rẫy', 'parent_code' =>  35, 'path_with_type' => 'Huyện Kon Rẫy, Tỉnh Kon Tum', 'type' => 'huyen'],
        615 => ['id' => 615, 'name' =>  'Đắk Hà', 'parent_code' =>  35, 'path_with_type' => 'Huyện Đắk Hà, Tỉnh Kon Tum', 'type' => 'huyen'],
        616 => ['id' => 616, 'name' =>  'Sa Thầy', 'parent_code' =>  35, 'path_with_type' => 'Huyện Sa Thầy, Tỉnh Kon Tum', 'type' => 'huyen'],
        617 => ['id' => 617, 'name' =>  'Tu Mơ Rông', 'parent_code' =>  35, 'path_with_type' => 'Huyện Tu Mơ Rông, Tỉnh Kon Tum', 'type' => 'huyen'],
        618 => ['id' => 618, 'name' =>  'Ia H Drai', 'parent_code' =>  35, 'path_with_type' => 'Huyện Ia H Drai, Tỉnh Kon Tum', 'type' => 'huyen'],
        622 => ['id' => 622, 'name' =>  'Pleiku', 'parent_code' =>  23, 'path_with_type' => 'Thành phố Pleiku, Tỉnh Gia Lai', 'type' => 'thanh-pho'],
        623 => ['id' => 623, 'name' =>  'An Khê', 'parent_code' =>  23, 'path_with_type' => 'Thị xã An Khê, Tỉnh Gia Lai', 'type' => 'thi-xa'],
        624 => ['id' => 624, 'name' =>  'Ayun Pa', 'parent_code' =>  23, 'path_with_type' => 'Thị xã Ayun Pa, Tỉnh Gia Lai', 'type' => 'thi-xa'],
        625 => ['id' => 625, 'name' =>  'KBang', 'parent_code' =>  23, 'path_with_type' => 'Huyện KBang, Tỉnh Gia Lai', 'type' => 'huyen'],
        626 => ['id' => 626, 'name' =>  'Đăk Đoa', 'parent_code' =>  23, 'path_with_type' => 'Huyện Đăk Đoa, Tỉnh Gia Lai', 'type' => 'huyen'],
        627 => ['id' => 627, 'name' =>  'Chư Păh', 'parent_code' =>  23, 'path_with_type' => 'Huyện Chư Păh, Tỉnh Gia Lai', 'type' => 'huyen'],
        628 => ['id' => 628, 'name' =>  'Ia Grai', 'parent_code' =>  23, 'path_with_type' => 'Huyện Ia Grai, Tỉnh Gia Lai', 'type' => 'huyen'],
        629 => ['id' => 629, 'name' =>  'Mang Yang', 'parent_code' =>  23, 'path_with_type' => 'Huyện Mang Yang, Tỉnh Gia Lai', 'type' => 'huyen'],
        630 => ['id' => 630, 'name' =>  'Kông Chro', 'parent_code' =>  23, 'path_with_type' => 'Huyện Kông Chro, Tỉnh Gia Lai', 'type' => 'huyen'],
        631 => ['id' => 631, 'name' =>  'Đức Cơ', 'parent_code' =>  23, 'path_with_type' => 'Huyện Đức Cơ, Tỉnh Gia Lai', 'type' => 'huyen'],
        632 => ['id' => 632, 'name' =>  'Chư Prông', 'parent_code' =>  23, 'path_with_type' => 'Huyện Chư Prông, Tỉnh Gia Lai', 'type' => 'huyen'],
        633 => ['id' => 633, 'name' =>  'Chư Sê', 'parent_code' =>  23, 'path_with_type' => 'Huyện Chư Sê, Tỉnh Gia Lai', 'type' => 'huyen'],
        634 => ['id' => 634, 'name' =>  'Đăk Pơ', 'parent_code' =>  23, 'path_with_type' => 'Huyện Đăk Pơ, Tỉnh Gia Lai', 'type' => 'huyen'],
        635 => ['id' => 635, 'name' =>  'Ia Pa', 'parent_code' =>  23, 'path_with_type' => 'Huyện Ia Pa, Tỉnh Gia Lai', 'type' => 'huyen'],
        637 => ['id' => 637, 'name' =>  'Krông Pa', 'parent_code' =>  23, 'path_with_type' => 'Huyện Krông Pa, Tỉnh Gia Lai', 'type' => 'huyen'],
        638 => ['id' => 638, 'name' =>  'Phú Thiện', 'parent_code' =>  23, 'path_with_type' => 'Huyện Phú Thiện, Tỉnh Gia Lai', 'type' => 'huyen'],
        639 => ['id' => 639, 'name' =>  'Chư Pưh', 'parent_code' =>  23, 'path_with_type' => 'Huyện Chư Pưh, Tỉnh Gia Lai', 'type' => 'huyen'],
        643 => ['id' => 643, 'name' =>  'Buôn Ma Thuột', 'parent_code' =>  18, 'path_with_type' => 'Thành phố Buôn Ma Thuột, Tỉnh Đắk Lắk', 'type' => 'thanh-pho'],
        644 => ['id' => 644, 'name' =>  'Buôn Hồ', 'parent_code' =>  18, 'path_with_type' => 'Thị xã Buôn Hồ, Tỉnh Đắk Lắk', 'type' => 'thi-xa'],
        645 => ['id' => 645, 'name' =>  'Ea H leo', 'parent_code' =>  18, 'path_with_type' => 'Huyện Ea H leo, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        646 => ['id' => 646, 'name' =>  'Ea Súp', 'parent_code' =>  18, 'path_with_type' => 'Huyện Ea Súp, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        647 => ['id' => 647, 'name' =>  'Buôn Đôn', 'parent_code' =>  18, 'path_with_type' => 'Huyện Buôn Đôn, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        648 => ['id' => 648, 'name' =>  'Cư M gar', 'parent_code' =>  18, 'path_with_type' => 'Huyện Cư M gar, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        649 => ['id' => 649, 'name' =>  'Krông Búk', 'parent_code' =>  18, 'path_with_type' => 'Huyện Krông Búk, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        650 => ['id' => 650, 'name' =>  'Krông Năng', 'parent_code' =>  18, 'path_with_type' => 'Huyện Krông Năng, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        651 => ['id' => 651, 'name' =>  'Ea Kar', 'parent_code' =>  18, 'path_with_type' => 'Huyện Ea Kar, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        652 => ['id' => 652, 'name' =>  'M Đrắk', 'parent_code' =>  18, 'path_with_type' => 'Huyện M Đrắk, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        653 => ['id' => 653, 'name' =>  'Krông Bông', 'parent_code' =>  18, 'path_with_type' => 'Huyện Krông Bông, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        654 => ['id' => 654, 'name' =>  'Krông Pắc', 'parent_code' =>  18, 'path_with_type' => 'Huyện Krông Pắc, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        655 => ['id' => 655, 'name' =>  'Krông A Na', 'parent_code' =>  18, 'path_with_type' => 'Huyện Krông A Na, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        656 => ['id' => 656, 'name' =>  'Lắk', 'parent_code' =>  18, 'path_with_type' => 'Huyện Lắk, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        657 => ['id' => 657, 'name' =>  'Cư Kuin', 'parent_code' =>  18, 'path_with_type' => 'Huyện Cư Kuin, Tỉnh Đắk Lắk', 'type' => 'huyen'],
        660 => ['id' => 660, 'name' =>  'Gia Nghĩa', 'parent_code' =>  19, 'path_with_type' => 'Thị xã Gia Nghĩa, Tỉnh Đắk Nông', 'type' => 'thi-xa'],
        661 => ['id' => 661, 'name' =>  'Đăk Glong', 'parent_code' =>  19, 'path_with_type' => 'Huyện Đăk Glong, Tỉnh Đắk Nông', 'type' => 'huyen'],
        662 => ['id' => 662, 'name' =>  'Cư Jút', 'parent_code' =>  19, 'path_with_type' => 'Huyện Cư Jút, Tỉnh Đắk Nông', 'type' => 'huyen'],
        663 => ['id' => 663, 'name' =>  'Đắk Mil', 'parent_code' =>  19, 'path_with_type' => 'Huyện Đắk Mil, Tỉnh Đắk Nông', 'type' => 'huyen'],
        664 => ['id' => 664, 'name' =>  'Krông Nô', 'parent_code' =>  19, 'path_with_type' => 'Huyện Krông Nô, Tỉnh Đắk Nông', 'type' => 'huyen'],
        665 => ['id' => 665, 'name' =>  'Đắk Song', 'parent_code' =>  19, 'path_with_type' => 'Huyện Đắk Song, Tỉnh Đắk Nông', 'type' => 'huyen'],
        666 => ['id' => 666, 'name' =>  'Đắk R Lấp', 'parent_code' =>  19, 'path_with_type' => 'Huyện Đắk R Lấp, Tỉnh Đắk Nông', 'type' => 'huyen'],
        667 => ['id' => 667, 'name' =>  'Tuy Đức', 'parent_code' =>  19, 'path_with_type' => 'Huyện Tuy Đức, Tỉnh Đắk Nông', 'type' => 'huyen'],
        672 => ['id' => 672, 'name' =>  'Đà Lạt', 'parent_code' =>  39, 'path_with_type' => 'Thành phố Đà Lạt, Tỉnh Lâm Đồng', 'type' => 'thanh-pho'],
        673 => ['id' => 673, 'name' =>  'Bảo Lộc', 'parent_code' =>  39, 'path_with_type' => 'Thành phố Bảo Lộc, Tỉnh Lâm Đồng', 'type' => 'thanh-pho'],
        674 => ['id' => 674, 'name' =>  'Đam Rông', 'parent_code' =>  39, 'path_with_type' => 'Huyện Đam Rông, Tỉnh Lâm Đồng', 'type' => 'huyen'],
        675 => ['id' => 675, 'name' =>  'Lạc Dương', 'parent_code' =>  39, 'path_with_type' => 'Huyện Lạc Dương, Tỉnh Lâm Đồng', 'type' => 'huyen'],
        676 => ['id' => 676, 'name' =>  'Lâm Hà', 'parent_code' =>  39, 'path_with_type' => 'Huyện Lâm Hà, Tỉnh Lâm Đồng', 'type' => 'huyen'],
        677 => ['id' => 677, 'name' =>  'Đơn Dương', 'parent_code' =>  39, 'path_with_type' => 'Huyện Đơn Dương, Tỉnh Lâm Đồng', 'type' => 'huyen'],
        678 => ['id' => 678, 'name' =>  'Đức Trọng', 'parent_code' =>  39, 'path_with_type' => 'Huyện Đức Trọng, Tỉnh Lâm Đồng', 'type' => 'huyen'],
        679 => ['id' => 679, 'name' =>  'Di Linh', 'parent_code' =>  39, 'path_with_type' => 'Huyện Di Linh, Tỉnh Lâm Đồng', 'type' => 'huyen'],
        680 => ['id' => 680, 'name' =>  'Bảo Lâm', 'parent_code' =>  39, 'path_with_type' => 'Huyện Bảo Lâm, Tỉnh Lâm Đồng', 'type' => 'huyen'],
        681 => ['id' => 681, 'name' =>  'Đạ Huoai', 'parent_code' =>  39, 'path_with_type' => 'Huyện Đạ Huoai, Tỉnh Lâm Đồng', 'type' => 'huyen'],
        682 => ['id' => 682, 'name' =>  'Đạ Tẻh', 'parent_code' =>  39, 'path_with_type' => 'Huyện Đạ Tẻh, Tỉnh Lâm Đồng', 'type' => 'huyen'],
        683 => ['id' => 683, 'name' =>  'Cát Tiên', 'parent_code' =>  39, 'path_with_type' => 'Huyện Cát Tiên, Tỉnh Lâm Đồng', 'type' => 'huyen'],
        688 => ['id' => 688, 'name' =>  'Phước Long', 'parent_code' =>  12, 'path_with_type' => 'Thị xã Phước Long, Tỉnh Bình Phước', 'type' => 'thi-xa'],
        689 => ['id' => 689, 'name' =>  'Đồng Xoài', 'parent_code' =>  12, 'path_with_type' => 'Thị xã Đồng Xoài, Tỉnh Bình Phước', 'type' => 'thi-xa'],
        690 => ['id' => 690, 'name' =>  'Bình Long', 'parent_code' =>  12, 'path_with_type' => 'Thị xã Bình Long, Tỉnh Bình Phước', 'type' => 'thi-xa'],
        691 => ['id' => 691, 'name' =>  'Bù Gia Mập', 'parent_code' =>  12, 'path_with_type' => 'Huyện Bù Gia Mập, Tỉnh Bình Phước', 'type' => 'huyen'],
        692 => ['id' => 692, 'name' =>  'Lộc Ninh', 'parent_code' =>  12, 'path_with_type' => 'Huyện Lộc Ninh, Tỉnh Bình Phước', 'type' => 'huyen'],
        693 => ['id' => 693, 'name' =>  'Bù Đốp', 'parent_code' =>  12, 'path_with_type' => 'Huyện Bù Đốp, Tỉnh Bình Phước', 'type' => 'huyen'],
        694 => ['id' => 694, 'name' =>  'Hớn Quản', 'parent_code' =>  12, 'path_with_type' => 'Huyện Hớn Quản, Tỉnh Bình Phước', 'type' => 'huyen'],
        695 => ['id' => 695, 'name' =>  'Đồng Phú', 'parent_code' =>  12, 'path_with_type' => 'Huyện Đồng Phú, Tỉnh Bình Phước', 'type' => 'huyen'],
        696 => ['id' => 696, 'name' =>  'Bù Đăng', 'parent_code' =>  12, 'path_with_type' => 'Huyện Bù Đăng, Tỉnh Bình Phước', 'type' => 'huyen'],
        697 => ['id' => 697, 'name' =>  'Chơn Thành', 'parent_code' =>  12, 'path_with_type' => 'Huyện Chơn Thành, Tỉnh Bình Phước', 'type' => 'huyen'],
        698 => ['id' => 698, 'name' =>  'Phú Riềng', 'parent_code' =>  12, 'path_with_type' => 'Huyện Phú Riềng, Tỉnh Bình Phước', 'type' => 'huyen'],
        703 => ['id' => 703, 'name' =>  'Tây Ninh', 'parent_code' =>  54, 'path_with_type' => 'Thành phố Tây Ninh, Tỉnh Tây Ninh', 'type' => 'thanh-pho'],
        705 => ['id' => 705, 'name' =>  'Tân Biên', 'parent_code' =>  54, 'path_with_type' => 'Huyện Tân Biên, Tỉnh Tây Ninh', 'type' => 'huyen'],
        706 => ['id' => 706, 'name' =>  'Tân Châu', 'parent_code' =>  54, 'path_with_type' => 'Huyện Tân Châu, Tỉnh Tây Ninh', 'type' => 'huyen'],
        707 => ['id' => 707, 'name' =>  'Dương Minh Châu', 'parent_code' =>  54, 'path_with_type' => 'Huyện Dương Minh Châu, Tỉnh Tây Ninh', 'type' => 'huyen'],
        708 => ['id' => 708, 'name' =>  'Châu Thành', 'parent_code' =>  54, 'path_with_type' => 'Huyện Châu Thành, Tỉnh Tây Ninh', 'type' => 'huyen'],
        709 => ['id' => 709, 'name' =>  'Hòa Thành', 'parent_code' =>  54, 'path_with_type' => 'Huyện Hòa Thành, Tỉnh Tây Ninh', 'type' => 'huyen'],
        710 => ['id' => 710, 'name' =>  'Gò Dầu', 'parent_code' =>  54, 'path_with_type' => 'Huyện Gò Dầu, Tỉnh Tây Ninh', 'type' => 'huyen'],
        711 => ['id' => 711, 'name' =>  'Bến Cầu', 'parent_code' =>  54, 'path_with_type' => 'Huyện Bến Cầu, Tỉnh Tây Ninh', 'type' => 'huyen'],
        712 => ['id' => 712, 'name' =>  'Trảng Bàng', 'parent_code' =>  54, 'path_with_type' => 'Huyện Trảng Bàng, Tỉnh Tây Ninh', 'type' => 'huyen'],
        718 => ['id' => 718, 'name' =>  'Thủ Dầu Một', 'parent_code' =>  10, 'path_with_type' => 'Thành phố Thủ Dầu Một, Tỉnh Bình Dương', 'type' => 'thanh-pho'],
        719 => ['id' => 719, 'name' =>  'Bàu Bàng', 'parent_code' =>  10, 'path_with_type' => 'Huyện Bàu Bàng, Tỉnh Bình Dương', 'type' => 'huyen'],
        720 => ['id' => 720, 'name' =>  'Dầu Tiếng', 'parent_code' =>  10, 'path_with_type' => 'Huyện Dầu Tiếng, Tỉnh Bình Dương', 'type' => 'huyen'],
        721 => ['id' => 721, 'name' =>  'Bến Cát', 'parent_code' =>  10, 'path_with_type' => 'Thị xã Bến Cát, Tỉnh Bình Dương', 'type' => 'thi-xa'],
        722 => ['id' => 722, 'name' =>  'Phú Giáo', 'parent_code' =>  10, 'path_with_type' => 'Huyện Phú Giáo, Tỉnh Bình Dương', 'type' => 'huyen'],
        723 => ['id' => 723, 'name' =>  'Tân Uyên', 'parent_code' =>  10, 'path_with_type' => 'Thị xã Tân Uyên, Tỉnh Bình Dương', 'type' => 'thi-xa'],
        724 => ['id' => 724, 'name' =>  'Dĩ An', 'parent_code' =>  10, 'path_with_type' => 'Thị xã Dĩ An, Tỉnh Bình Dương', 'type' => 'thi-xa'],
        725 => ['id' => 725, 'name' =>  'Thuận An', 'parent_code' =>  10, 'path_with_type' => 'Thị xã Thuận An, Tỉnh Bình Dương', 'type' => 'thi-xa'],
        726 => ['id' => 726, 'name' =>  'Bắc Tân Uyên', 'parent_code' =>  10, 'path_with_type' => 'Huyện Bắc Tân Uyên, Tỉnh Bình Dương', 'type' => 'huyen'],
        731 => ['id' => 731, 'name' =>  'Biên Hòa', 'parent_code' =>  21, 'path_with_type' => 'Thành phố Biên Hòa, Tỉnh Đồng Nai', 'type' => 'thanh-pho'],
        732 => ['id' => 732, 'name' =>  'Long Khánh', 'parent_code' =>  21, 'path_with_type' => 'Thị xã Long Khánh, Tỉnh Đồng Nai', 'type' => 'thi-xa'],
        734 => ['id' => 734, 'name' =>  'Tân Phú', 'parent_code' =>  21, 'path_with_type' => 'Huyện Tân Phú, Tỉnh Đồng Nai', 'type' => 'huyen'],
        735 => ['id' => 735, 'name' =>  'Vĩnh Cửu', 'parent_code' =>  21, 'path_with_type' => 'Huyện Vĩnh Cửu, Tỉnh Đồng Nai', 'type' => 'huyen'],
        736 => ['id' => 736, 'name' =>  'Định Quán', 'parent_code' =>  21, 'path_with_type' => 'Huyện Định Quán, Tỉnh Đồng Nai', 'type' => 'huyen'],
        737 => ['id' => 737, 'name' =>  'Trảng Bom', 'parent_code' =>  21, 'path_with_type' => 'Huyện Trảng Bom, Tỉnh Đồng Nai', 'type' => 'huyen'],
        738 => ['id' => 738, 'name' =>  'Thống Nhất', 'parent_code' =>  21, 'path_with_type' => 'Huyện Thống Nhất, Tỉnh Đồng Nai', 'type' => 'huyen'],
        739 => ['id' => 739, 'name' =>  'Cẩm Mỹ', 'parent_code' =>  21, 'path_with_type' => 'Huyện Cẩm Mỹ, Tỉnh Đồng Nai', 'type' => 'huyen'],
        740 => ['id' => 740, 'name' =>  'Long Thành', 'parent_code' =>  21, 'path_with_type' => 'Huyện Long Thành, Tỉnh Đồng Nai', 'type' => 'huyen'],
        741 => ['id' => 741, 'name' =>  'Xuân Lộc', 'parent_code' =>  21, 'path_with_type' => 'Huyện Xuân Lộc, Tỉnh Đồng Nai', 'type' => 'huyen'],
        742 => ['id' => 742, 'name' =>  'Nhơn Trạch', 'parent_code' =>  21, 'path_with_type' => 'Huyện Nhơn Trạch, Tỉnh Đồng Nai', 'type' => 'huyen'],
        747 => ['id' => 747, 'name' =>  'Vũng Tàu', 'parent_code' =>  5, 'path_with_type' => 'Thành phố Vũng Tàu, Tỉnh Bà Rịa - Vũng Tàu', 'type' => 'thanh-pho'],
        748 => ['id' => 748, 'name' =>  'Bà Rịa', 'parent_code' =>  5, 'path_with_type' => 'Thành phố Bà Rịa, Tỉnh Bà Rịa - Vũng Tàu', 'type' => 'thanh-pho'],
        750 => ['id' => 750, 'name' =>  'Châu Đức', 'parent_code' =>  5, 'path_with_type' => 'Huyện Châu Đức, Tỉnh Bà Rịa - Vũng Tàu', 'type' => 'huyen'],
        751 => ['id' => 751, 'name' =>  'Xuyên Mộc', 'parent_code' =>  5, 'path_with_type' => 'Huyện Xuyên Mộc, Tỉnh Bà Rịa - Vũng Tàu', 'type' => 'huyen'],
        752 => ['id' => 752, 'name' =>  'Long Điền', 'parent_code' =>  5, 'path_with_type' => 'Huyện Long Điền, Tỉnh Bà Rịa - Vũng Tàu', 'type' => 'huyen'],
        753 => ['id' => 753, 'name' =>  'Đất Đỏ', 'parent_code' =>  5, 'path_with_type' => 'Huyện Đất Đỏ, Tỉnh Bà Rịa - Vũng Tàu', 'type' => 'huyen'],
        754 => ['id' => 754, 'name' =>  'Tân Thành', 'parent_code' =>  5, 'path_with_type' => 'Huyện Tân Thành, Tỉnh Bà Rịa - Vũng Tàu', 'type' => 'huyen'],
        760 => ['id' => 760, 'name' =>  '1', 'parent_code' =>  2, 'path_with_type' => 'Quận 1, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        761 => ['id' => 761, 'name' =>  '12', 'parent_code' =>  2, 'path_with_type' => 'Quận 12, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        762 => ['id' => 762, 'name' =>  'Thủ Đức', 'parent_code' =>  2, 'path_with_type' => 'Quận Thủ Đức, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        763 => ['id' => 763, 'name' =>  '9', 'parent_code' =>  2, 'path_with_type' => 'Quận 9, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        764 => ['id' => 764, 'name' =>  'Gò Vấp', 'parent_code' =>  2, 'path_with_type' => 'Quận Gò Vấp, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        765 => ['id' => 765, 'name' =>  'Bình Thạnh', 'parent_code' =>  2, 'path_with_type' => 'Quận Bình Thạnh, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        766 => ['id' => 766, 'name' =>  'Tân Bình', 'parent_code' =>  2, 'path_with_type' => 'Quận Tân Bình, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        767 => ['id' => 767, 'name' =>  'Tân Phú', 'parent_code' =>  2, 'path_with_type' => 'Quận Tân Phú, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        768 => ['id' => 768, 'name' =>  'Phú Nhuận', 'parent_code' =>  2, 'path_with_type' => 'Quận Phú Nhuận, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        769 => ['id' => 769, 'name' =>  '2', 'parent_code' =>  2, 'path_with_type' => 'Quận 2, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        770 => ['id' => 770, 'name' =>  '3', 'parent_code' =>  2, 'path_with_type' => 'Quận 3, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        771 => ['id' => 771, 'name' =>  '10', 'parent_code' =>  2, 'path_with_type' => 'Quận 10, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        772 => ['id' => 772, 'name' =>  '11', 'parent_code' =>  2, 'path_with_type' => 'Quận 11, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        773 => ['id' => 773, 'name' =>  '4', 'parent_code' =>  2, 'path_with_type' => 'Quận 4, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        774 => ['id' => 774, 'name' =>  '5', 'parent_code' =>  2, 'path_with_type' => 'Quận 5, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        775 => ['id' => 775, 'name' =>  '6', 'parent_code' =>  2, 'path_with_type' => 'Quận 6, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        776 => ['id' => 776, 'name' =>  '8', 'parent_code' =>  2, 'path_with_type' => 'Quận 8, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        777 => ['id' => 777, 'name' =>  'Bình Tân', 'parent_code' =>  2, 'path_with_type' => 'Quận Bình Tân, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        778 => ['id' => 778, 'name' =>  '7', 'parent_code' =>  2, 'path_with_type' => 'Quận 7, Thành phố Hồ Chí Minh', 'type' => 'quan'],
        783 => ['id' => 783, 'name' =>  'Củ Chi', 'parent_code' =>  2, 'path_with_type' => 'Huyện Củ Chi, Thành phố Hồ Chí Minh', 'type' => 'huyen'],
        784 => ['id' => 784, 'name' =>  'Hóc Môn', 'parent_code' =>  2, 'path_with_type' => 'Huyện Hóc Môn, Thành phố Hồ Chí Minh', 'type' => 'huyen'],
        785 => ['id' => 785, 'name' =>  'Bình Chánh', 'parent_code' =>  2, 'path_with_type' => 'Huyện Bình Chánh, Thành phố Hồ Chí Minh', 'type' => 'huyen'],
        786 => ['id' => 786, 'name' =>  'Nhà Bè', 'parent_code' =>  2, 'path_with_type' => 'Huyện Nhà Bè, Thành phố Hồ Chí Minh', 'type' => 'huyen'],
        787 => ['id' => 787, 'name' =>  'Cần Giờ', 'parent_code' =>  2, 'path_with_type' => 'Huyện Cần Giờ, Thành phố Hồ Chí Minh', 'type' => 'huyen'],
        794 => ['id' => 794, 'name' =>  'Tân An', 'parent_code' =>  40, 'path_with_type' => 'Thành phố Tân An, Tỉnh Long An', 'type' => 'thanh-pho'],
        795 => ['id' => 795, 'name' =>  'Kiến Tường', 'parent_code' =>  40, 'path_with_type' => 'Thị xã Kiến Tường, Tỉnh Long An', 'type' => 'thi-xa'],
        796 => ['id' => 796, 'name' =>  'Tân Hưng', 'parent_code' =>  40, 'path_with_type' => 'Huyện Tân Hưng, Tỉnh Long An', 'type' => 'huyen'],
        797 => ['id' => 797, 'name' =>  'Vĩnh Hưng', 'parent_code' =>  40, 'path_with_type' => 'Huyện Vĩnh Hưng, Tỉnh Long An', 'type' => 'huyen'],
        798 => ['id' => 798, 'name' =>  'Mộc Hóa', 'parent_code' =>  40, 'path_with_type' => 'Huyện Mộc Hóa, Tỉnh Long An', 'type' => 'huyen'],
        799 => ['id' => 799, 'name' =>  'Tân Thạnh', 'parent_code' =>  40, 'path_with_type' => 'Huyện Tân Thạnh, Tỉnh Long An', 'type' => 'huyen'],
        800 => ['id' => 800, 'name' =>  'Thạnh Hóa', 'parent_code' =>  40, 'path_with_type' => 'Huyện Thạnh Hóa, Tỉnh Long An', 'type' => 'huyen'],
        801 => ['id' => 801, 'name' =>  'Đức Huệ', 'parent_code' =>  40, 'path_with_type' => 'Huyện Đức Huệ, Tỉnh Long An', 'type' => 'huyen'],
        802 => ['id' => 802, 'name' =>  'Đức Hòa', 'parent_code' =>  40, 'path_with_type' => 'Huyện Đức Hòa, Tỉnh Long An', 'type' => 'huyen'],
        803 => ['id' => 803, 'name' =>  'Bến Lức', 'parent_code' =>  40, 'path_with_type' => 'Huyện Bến Lức, Tỉnh Long An', 'type' => 'huyen'],
        804 => ['id' => 804, 'name' =>  'Thủ Thừa', 'parent_code' =>  40, 'path_with_type' => 'Huyện Thủ Thừa, Tỉnh Long An', 'type' => 'huyen'],
        805 => ['id' => 805, 'name' =>  'Tân Trụ', 'parent_code' =>  40, 'path_with_type' => 'Huyện Tân Trụ, Tỉnh Long An', 'type' => 'huyen'],
        806 => ['id' => 806, 'name' =>  'Cần Đước', 'parent_code' =>  40, 'path_with_type' => 'Huyện Cần Đước, Tỉnh Long An', 'type' => 'huyen'],
        807 => ['id' => 807, 'name' =>  'Cần Giuộc', 'parent_code' =>  40, 'path_with_type' => 'Huyện Cần Giuộc, Tỉnh Long An', 'type' => 'huyen'],
        808 => ['id' => 808, 'name' =>  'Châu Thành', 'parent_code' =>  40, 'path_with_type' => 'Huyện Châu Thành, Tỉnh Long An', 'type' => 'huyen'],
        815 => ['id' => 815, 'name' =>  'Mỹ Tho', 'parent_code' =>  59, 'path_with_type' => 'Thành phố Mỹ Tho, Tỉnh Tiền Giang', 'type' => 'thanh-pho'],
        816 => ['id' => 816, 'name' =>  'Gò Công', 'parent_code' =>  59, 'path_with_type' => 'Thị xã Gò Công, Tỉnh Tiền Giang', 'type' => 'thi-xa'],
        817 => ['id' => 817, 'name' =>  'Cai Lậy', 'parent_code' =>  59, 'path_with_type' => 'Thị xã Cai Lậy, Tỉnh Tiền Giang', 'type' => 'thi-xa'],
        818 => ['id' => 818, 'name' =>  'Tân Phước', 'parent_code' =>  59, 'path_with_type' => 'Huyện Tân Phước, Tỉnh Tiền Giang', 'type' => 'huyen'],
        819 => ['id' => 819, 'name' =>  'Cái Bè', 'parent_code' =>  59, 'path_with_type' => 'Huyện Cái Bè, Tỉnh Tiền Giang', 'type' => 'huyen'],
        820 => ['id' => 820, 'name' =>  'Cai Lậy', 'parent_code' =>  59, 'path_with_type' => 'Huyện Cai Lậy, Tỉnh Tiền Giang', 'type' => 'huyen'],
        821 => ['id' => 821, 'name' =>  'Châu Thành', 'parent_code' =>  59, 'path_with_type' => 'Huyện Châu Thành, Tỉnh Tiền Giang', 'type' => 'huyen'],
        822 => ['id' => 822, 'name' =>  'Chợ Gạo', 'parent_code' =>  59, 'path_with_type' => 'Huyện Chợ Gạo, Tỉnh Tiền Giang', 'type' => 'huyen'],
        823 => ['id' => 823, 'name' =>  'Gò Công Tây', 'parent_code' =>  59, 'path_with_type' => 'Huyện Gò Công Tây, Tỉnh Tiền Giang', 'type' => 'huyen'],
        824 => ['id' => 824, 'name' =>  'Gò Công Đông', 'parent_code' =>  59, 'path_with_type' => 'Huyện Gò Công Đông, Tỉnh Tiền Giang', 'type' => 'huyen'],
        825 => ['id' => 825, 'name' =>  'Tân Phú Đông', 'parent_code' =>  59, 'path_with_type' => 'Huyện Tân Phú Đông, Tỉnh Tiền Giang', 'type' => 'huyen'],
        829 => ['id' => 829, 'name' =>  'Bến Tre', 'parent_code' =>  9, 'path_with_type' => 'Thành phố Bến Tre, Tỉnh Bến Tre', 'type' => 'thanh-pho'],
        831 => ['id' => 831, 'name' =>  'Châu Thành', 'parent_code' =>  9, 'path_with_type' => 'Huyện Châu Thành, Tỉnh Bến Tre', 'type' => 'huyen'],
        832 => ['id' => 832, 'name' =>  'Chợ Lách', 'parent_code' =>  9, 'path_with_type' => 'Huyện Chợ Lách, Tỉnh Bến Tre', 'type' => 'huyen'],
        833 => ['id' => 833, 'name' =>  'Mỏ Cày Nam', 'parent_code' =>  9, 'path_with_type' => 'Huyện Mỏ Cày Nam, Tỉnh Bến Tre', 'type' => 'huyen'],
        834 => ['id' => 834, 'name' =>  'Giồng Trôm', 'parent_code' =>  9, 'path_with_type' => 'Huyện Giồng Trôm, Tỉnh Bến Tre', 'type' => 'huyen'],
        835 => ['id' => 835, 'name' =>  'Bình Đại', 'parent_code' =>  9, 'path_with_type' => 'Huyện Bình Đại, Tỉnh Bến Tre', 'type' => 'huyen'],
        836 => ['id' => 836, 'name' =>  'Ba Tri', 'parent_code' =>  9, 'path_with_type' => 'Huyện Ba Tri, Tỉnh Bến Tre', 'type' => 'huyen'],
        837 => ['id' => 837, 'name' =>  'Thạnh Phú', 'parent_code' =>  9, 'path_with_type' => 'Huyện Thạnh Phú, Tỉnh Bến Tre', 'type' => 'huyen'],
        838 => ['id' => 838, 'name' =>  'Mỏ Cày Bắc', 'parent_code' =>  9, 'path_with_type' => 'Huyện Mỏ Cày Bắc, Tỉnh Bến Tre', 'type' => 'huyen'],
        842 => ['id' => 842, 'name' =>  'Trà Vinh', 'parent_code' =>  60, 'path_with_type' => 'Thành phố Trà Vinh, Tỉnh Trà Vinh', 'type' => 'thanh-pho'],
        844 => ['id' => 844, 'name' =>  'Càng Long', 'parent_code' =>  60, 'path_with_type' => 'Huyện Càng Long, Tỉnh Trà Vinh', 'type' => 'huyen'],
        845 => ['id' => 845, 'name' =>  'Cầu Kè', 'parent_code' =>  60, 'path_with_type' => 'Huyện Cầu Kè, Tỉnh Trà Vinh', 'type' => 'huyen'],
        846 => ['id' => 846, 'name' =>  'Tiểu Cần', 'parent_code' =>  60, 'path_with_type' => 'Huyện Tiểu Cần, Tỉnh Trà Vinh', 'type' => 'huyen'],
        847 => ['id' => 847, 'name' =>  'Châu Thành', 'parent_code' =>  60, 'path_with_type' => 'Huyện Châu Thành, Tỉnh Trà Vinh', 'type' => 'huyen'],
        848 => ['id' => 848, 'name' =>  'Cầu Ngang', 'parent_code' =>  60, 'path_with_type' => 'Huyện Cầu Ngang, Tỉnh Trà Vinh', 'type' => 'huyen'],
        849 => ['id' => 849, 'name' =>  'Trà Cú', 'parent_code' =>  60, 'path_with_type' => 'Huyện Trà Cú, Tỉnh Trà Vinh', 'type' => 'huyen'],
        850 => ['id' => 850, 'name' =>  'Duyên Hải', 'parent_code' =>  60, 'path_with_type' => 'Huyện Duyên Hải, Tỉnh Trà Vinh', 'type' => 'huyen'],
        851 => ['id' => 851, 'name' =>  'Duyên Hải', 'parent_code' =>  60, 'path_with_type' => 'Thị xã Duyên Hải, Tỉnh Trà Vinh', 'type' => 'thi-xa'],
        855 => ['id' => 855, 'name' =>  'Vĩnh Long', 'parent_code' =>  62, 'path_with_type' => 'Thành phố Vĩnh Long, Tỉnh Vĩnh Long', 'type' => 'thanh-pho'],
        857 => ['id' => 857, 'name' =>  'Long Hồ', 'parent_code' =>  62, 'path_with_type' => 'Huyện Long Hồ, Tỉnh Vĩnh Long', 'type' => 'huyen'],
        858 => ['id' => 858, 'name' =>  'Mang Thít', 'parent_code' =>  62, 'path_with_type' => 'Huyện Mang Thít, Tỉnh Vĩnh Long', 'type' => 'huyen'],
        859 => ['id' => 859, 'name' =>  'Vũng Liêm', 'parent_code' =>  62, 'path_with_type' => 'Huyện  Vũng Liêm, Tỉnh Vĩnh Long', 'type' => 'huyen'],
        860 => ['id' => 860, 'name' =>  'Tam Bình', 'parent_code' =>  62, 'path_with_type' => 'Huyện Tam Bình, Tỉnh Vĩnh Long', 'type' => 'huyen'],
        861 => ['id' => 861, 'name' =>  'Bình Minh', 'parent_code' =>  62, 'path_with_type' => 'Thị xã Bình Minh, Tỉnh Vĩnh Long', 'type' => 'thi-xa'],
        862 => ['id' => 862, 'name' =>  'Trà Ôn', 'parent_code' =>  62, 'path_with_type' => 'Huyện Trà Ôn, Tỉnh Vĩnh Long', 'type' => 'huyen'],
        863 => ['id' => 863, 'name' =>  'Bình Tân', 'parent_code' =>  62, 'path_with_type' => 'Huyện Bình Tân, Tỉnh Vĩnh Long', 'type' => 'huyen'],
        866 => ['id' => 866, 'name' =>  'Cao Lãnh', 'parent_code' =>  22, 'path_with_type' => 'Thành phố Cao Lãnh, Tỉnh Đồng Tháp', 'type' => 'thanh-pho'],
        867 => ['id' => 867, 'name' =>  'Sa Đéc', 'parent_code' =>  22, 'path_with_type' => 'Thành phố Sa Đéc, Tỉnh Đồng Tháp', 'type' => 'thanh-pho'],
        868 => ['id' => 868, 'name' =>  'Hồng Ngự', 'parent_code' =>  22, 'path_with_type' => 'Thị xã Hồng Ngự, Tỉnh Đồng Tháp', 'type' => 'thi-xa'],
        869 => ['id' => 869, 'name' =>  'Tân Hồng', 'parent_code' =>  22, 'path_with_type' => 'Huyện Tân Hồng, Tỉnh Đồng Tháp', 'type' => 'huyen'],
        870 => ['id' => 870, 'name' =>  'Hồng Ngự', 'parent_code' =>  22, 'path_with_type' => 'Huyện Hồng Ngự, Tỉnh Đồng Tháp', 'type' => 'huyen'],
        871 => ['id' => 871, 'name' =>  'Tam Nông', 'parent_code' =>  22, 'path_with_type' => 'Huyện Tam Nông, Tỉnh Đồng Tháp', 'type' => 'huyen'],
        872 => ['id' => 872, 'name' =>  'Tháp Mười', 'parent_code' =>  22, 'path_with_type' => 'Huyện Tháp Mười, Tỉnh Đồng Tháp', 'type' => 'huyen'],
        873 => ['id' => 873, 'name' =>  'Cao Lãnh', 'parent_code' =>  22, 'path_with_type' => 'Huyện Cao Lãnh, Tỉnh Đồng Tháp', 'type' => 'huyen'],
        874 => ['id' => 874, 'name' =>  'Thanh Bình', 'parent_code' =>  22, 'path_with_type' => 'Huyện Thanh Bình, Tỉnh Đồng Tháp', 'type' => 'huyen'],
        875 => ['id' => 875, 'name' =>  'Lấp Vò', 'parent_code' =>  22, 'path_with_type' => 'Huyện Lấp Vò, Tỉnh Đồng Tháp', 'type' => 'huyen'],
        876 => ['id' => 876, 'name' =>  'Lai Vung', 'parent_code' =>  22, 'path_with_type' => 'Huyện Lai Vung, Tỉnh Đồng Tháp', 'type' => 'huyen'],
        877 => ['id' => 877, 'name' =>  'Châu Thành', 'parent_code' =>  22, 'path_with_type' => 'Huyện Châu Thành, Tỉnh Đồng Tháp', 'type' => 'huyen'],
        883 => ['id' => 883, 'name' =>  'Long Xuyên', 'parent_code' =>  3, 'path_with_type' => 'Thành phố Long Xuyên, Tỉnh An Giang', 'type' => 'thanh-pho'],
        884 => ['id' => 884, 'name' =>  'Châu Đốc', 'parent_code' =>  3, 'path_with_type' => 'Thành phố Châu Đốc, Tỉnh An Giang', 'type' => 'thanh-pho'],
        886 => ['id' => 886, 'name' =>  'An Phú', 'parent_code' =>  3, 'path_with_type' => 'Huyện An Phú, Tỉnh An Giang', 'type' => 'huyen'],
        887 => ['id' => 887, 'name' =>  'Tân Châu', 'parent_code' =>  3, 'path_with_type' => 'Thị xã Tân Châu, Tỉnh An Giang', 'type' => 'thi-xa'],
        888 => ['id' => 888, 'name' =>  'Phú Tân', 'parent_code' =>  3, 'path_with_type' => 'Huyện Phú Tân, Tỉnh An Giang', 'type' => 'huyen'],
        889 => ['id' => 889, 'name' =>  'Châu Phú', 'parent_code' =>  3, 'path_with_type' => 'Huyện Châu Phú, Tỉnh An Giang', 'type' => 'huyen'],
        890 => ['id' => 890, 'name' =>  'Tịnh Biên', 'parent_code' =>  3, 'path_with_type' => 'Huyện Tịnh Biên, Tỉnh An Giang', 'type' => 'huyen'],
        891 => ['id' => 891, 'name' =>  'Tri Tôn', 'parent_code' =>  3, 'path_with_type' => 'Huyện Tri Tôn, Tỉnh An Giang', 'type' => 'huyen'],
        892 => ['id' => 892, 'name' =>  'Châu Thành', 'parent_code' =>  3, 'path_with_type' => 'Huyện Châu Thành, Tỉnh An Giang', 'type' => 'huyen'],
        893 => ['id' => 893, 'name' =>  'Chợ Mới', 'parent_code' =>  3, 'path_with_type' => 'Huyện Chợ Mới, Tỉnh An Giang', 'type' => 'huyen'],
        894 => ['id' => 894, 'name' =>  'Thoại Sơn', 'parent_code' =>  3, 'path_with_type' => 'Huyện Thoại Sơn, Tỉnh An Giang', 'type' => 'huyen'],
        899 => ['id' => 899, 'name' =>  'Rạch Giá', 'parent_code' =>  34, 'path_with_type' => 'Thành phố Rạch Giá, Tỉnh Kiên Giang', 'type' => 'thanh-pho'],
        900 => ['id' => 900, 'name' =>  'Hà Tiên', 'parent_code' =>  34, 'path_with_type' => 'Thị xã Hà Tiên, Tỉnh Kiên Giang', 'type' => 'thi-xa'],
        902 => ['id' => 902, 'name' =>  'Kiên Lương', 'parent_code' =>  34, 'path_with_type' => 'Huyện Kiên Lương, Tỉnh Kiên Giang', 'type' => 'huyen'],
        903 => ['id' => 903, 'name' =>  'Hòn Đất', 'parent_code' =>  34, 'path_with_type' => 'Huyện Hòn Đất, Tỉnh Kiên Giang', 'type' => 'huyen'],
        904 => ['id' => 904, 'name' =>  'Tân Hiệp', 'parent_code' =>  34, 'path_with_type' => 'Huyện Tân Hiệp, Tỉnh Kiên Giang', 'type' => 'huyen'],
        905 => ['id' => 905, 'name' =>  'Châu Thành', 'parent_code' =>  34, 'path_with_type' => 'Huyện Châu Thành, Tỉnh Kiên Giang', 'type' => 'huyen'],
        906 => ['id' => 906, 'name' =>  'Giồng Riềng', 'parent_code' =>  34, 'path_with_type' => 'Huyện Giồng Riềng, Tỉnh Kiên Giang', 'type' => 'huyen'],
        907 => ['id' => 907, 'name' =>  'Gò Quao', 'parent_code' =>  34, 'path_with_type' => 'Huyện Gò Quao, Tỉnh Kiên Giang', 'type' => 'huyen'],
        908 => ['id' => 908, 'name' =>  'An Biên', 'parent_code' =>  34, 'path_with_type' => 'Huyện An Biên, Tỉnh Kiên Giang', 'type' => 'huyen'],
        909 => ['id' => 909, 'name' =>  'An Minh', 'parent_code' =>  34, 'path_with_type' => 'Huyện An Minh, Tỉnh Kiên Giang', 'type' => 'huyen'],
        910 => ['id' => 910, 'name' =>  'Vĩnh Thuận', 'parent_code' =>  34, 'path_with_type' => 'Huyện Vĩnh Thuận, Tỉnh Kiên Giang', 'type' => 'huyen'],
        911 => ['id' => 911, 'name' =>  'Phú Quốc', 'parent_code' =>  34, 'path_with_type' => 'Huyện Phú Quốc, Tỉnh Kiên Giang', 'type' => 'huyen'],
        912 => ['id' => 912, 'name' =>  'Kiên Hải', 'parent_code' =>  34, 'path_with_type' => 'Huyện Kiên Hải, Tỉnh Kiên Giang', 'type' => 'huyen'],
        913 => ['id' => 913, 'name' =>  'U Minh Thượng', 'parent_code' =>  34, 'path_with_type' => 'Huyện U Minh Thượng, Tỉnh Kiên Giang', 'type' => 'huyen'],
        914 => ['id' => 914, 'name' =>  'Giang Thành', 'parent_code' =>  34, 'path_with_type' => 'Huyện Giang Thành, Tỉnh Kiên Giang', 'type' => 'huyen'],
        916 => ['id' => 916, 'name' =>  'Ninh Kiều', 'parent_code' =>  16, 'path_with_type' => 'Quận Ninh Kiều, Thành phố Cần Thơ', 'type' => 'quan'],
        917 => ['id' => 917, 'name' =>  'Ô Môn', 'parent_code' =>  16, 'path_with_type' => 'Quận Ô Môn, Thành phố Cần Thơ', 'type' => 'quan'],
        918 => ['id' => 918, 'name' =>  'Bình Thuỷ', 'parent_code' =>  16, 'path_with_type' => 'Quận Bình Thuỷ, Thành phố Cần Thơ', 'type' => 'quan'],
        919 => ['id' => 919, 'name' =>  'Cái Răng', 'parent_code' =>  16, 'path_with_type' => 'Quận Cái Răng, Thành phố Cần Thơ', 'type' => 'quan'],
        923 => ['id' => 923, 'name' =>  'Thốt Nốt', 'parent_code' =>  16, 'path_with_type' => 'Quận Thốt Nốt, Thành phố Cần Thơ', 'type' => 'quan'],
        924 => ['id' => 924, 'name' =>  'Vĩnh Thạnh', 'parent_code' =>  16, 'path_with_type' => 'Huyện Vĩnh Thạnh, Thành phố Cần Thơ', 'type' => 'huyen'],
        925 => ['id' => 925, 'name' =>  'Cờ Đỏ', 'parent_code' =>  16, 'path_with_type' => 'Huyện Cờ Đỏ, Thành phố Cần Thơ', 'type' => 'huyen'],
        926 => ['id' => 926, 'name' =>  'Phong Điền', 'parent_code' =>  16, 'path_with_type' => 'Huyện Phong Điền, Thành phố Cần Thơ', 'type' => 'huyen'],
        927 => ['id' => 927, 'name' =>  'Thới Lai', 'parent_code' =>  16, 'path_with_type' => 'Huyện Thới Lai, Thành phố Cần Thơ', 'type' => 'huyen'],
        930 => ['id' => 930, 'name' =>  'Vị Thanh', 'parent_code' =>  30, 'path_with_type' => 'Thành phố Vị Thanh, Tỉnh Hậu Giang', 'type' => 'thanh-pho'],
        931 => ['id' => 931, 'name' =>  'Ngã Bảy', 'parent_code' =>  30, 'path_with_type' => 'Thị xã Ngã Bảy, Tỉnh Hậu Giang', 'type' => 'thi-xa'],
        932 => ['id' => 932, 'name' =>  'Châu Thành A', 'parent_code' =>  30, 'path_with_type' => 'Huyện Châu Thành A, Tỉnh Hậu Giang', 'type' => 'huyen'],
        933 => ['id' => 933, 'name' =>  'Châu Thành', 'parent_code' =>  30, 'path_with_type' => 'Huyện Châu Thành, Tỉnh Hậu Giang', 'type' => 'huyen'],
        934 => ['id' => 934, 'name' =>  'Phụng Hiệp', 'parent_code' =>  30, 'path_with_type' => 'Huyện Phụng Hiệp, Tỉnh Hậu Giang', 'type' => 'huyen'],
        935 => ['id' => 935, 'name' =>  'Vị Thuỷ', 'parent_code' =>  30, 'path_with_type' => 'Huyện Vị Thuỷ, Tỉnh Hậu Giang', 'type' => 'huyen'],
        936 => ['id' => 936, 'name' =>  'Long Mỹ', 'parent_code' =>  30, 'path_with_type' => 'Huyện Long Mỹ, Tỉnh Hậu Giang', 'type' => 'huyen'],
        937 => ['id' => 937, 'name' =>  'Long Mỹ', 'parent_code' =>  30, 'path_with_type' => 'Thị xã Long Mỹ, Tỉnh Hậu Giang', 'type' => 'thi-xa'],
        941 => ['id' => 941, 'name' =>  'Sóc Trăng', 'parent_code' =>  52, 'path_with_type' => 'Thành phố Sóc Trăng, Tỉnh Sóc Trăng', 'type' => 'thanh-pho'],
        942 => ['id' => 942, 'name' =>  'Châu Thành', 'parent_code' =>  52, 'path_with_type' => 'Huyện Châu Thành, Tỉnh Sóc Trăng', 'type' => 'huyen'],
        943 => ['id' => 943, 'name' =>  'Kế Sách', 'parent_code' =>  52, 'path_with_type' => 'Huyện Kế Sách, Tỉnh Sóc Trăng', 'type' => 'huyen'],
        944 => ['id' => 944, 'name' =>  'Mỹ Tú', 'parent_code' =>  52, 'path_with_type' => 'Huyện Mỹ Tú, Tỉnh Sóc Trăng', 'type' => 'huyen'],
        945 => ['id' => 945, 'name' =>  'Cù Lao Dung', 'parent_code' =>  52, 'path_with_type' => 'Huyện Cù Lao Dung, Tỉnh Sóc Trăng', 'type' => 'huyen'],
        946 => ['id' => 946, 'name' =>  'Long Phú', 'parent_code' =>  52, 'path_with_type' => 'Huyện Long Phú, Tỉnh Sóc Trăng', 'type' => 'huyen'],
        947 => ['id' => 947, 'name' =>  'Mỹ Xuyên', 'parent_code' =>  52, 'path_with_type' => 'Huyện Mỹ Xuyên, Tỉnh Sóc Trăng', 'type' => 'huyen'],
        948 => ['id' => 948, 'name' =>  'Ngã Năm', 'parent_code' =>  52, 'path_with_type' => 'Thị xã Ngã Năm, Tỉnh Sóc Trăng', 'type' => 'thi-xa'],
        949 => ['id' => 949, 'name' =>  'Thạnh Trị', 'parent_code' =>  52, 'path_with_type' => 'Huyện Thạnh Trị, Tỉnh Sóc Trăng', 'type' => 'huyen'],
        950 => ['id' => 950, 'name' =>  'Vĩnh Châu', 'parent_code' =>  52, 'path_with_type' => 'Thị xã Vĩnh Châu, Tỉnh Sóc Trăng', 'type' => 'thi-xa'],
        951 => ['id' => 951, 'name' =>  'Trần Đề', 'parent_code' =>  52, 'path_with_type' => 'Huyện Trần Đề, Tỉnh Sóc Trăng', 'type' => 'huyen'],
        954 => ['id' => 954, 'name' =>  'Bạc Liêu', 'parent_code' =>  4, 'path_with_type' => 'Thành phố Bạc Liêu, Tỉnh Bạc Liêu', 'type' => 'thanh-pho'],
        956 => ['id' => 956, 'name' =>  'Hồng Dân', 'parent_code' =>  4, 'path_with_type' => 'Huyện Hồng Dân, Tỉnh Bạc Liêu', 'type' => 'huyen'],
        957 => ['id' => 957, 'name' =>  'Phước Long', 'parent_code' =>  4, 'path_with_type' => 'Huyện Phước Long, Tỉnh Bạc Liêu', 'type' => 'huyen'],
        958 => ['id' => 958, 'name' =>  'Vĩnh Lợi', 'parent_code' =>  4, 'path_with_type' => 'Huyện Vĩnh Lợi, Tỉnh Bạc Liêu', 'type' => 'huyen'],
        959 => ['id' => 959, 'name' =>  'Giá Rai', 'parent_code' =>  4, 'path_with_type' => 'Thị xã Giá Rai, Tỉnh Bạc Liêu', 'type' => 'thi-xa'],
        960 => ['id' => 960, 'name' =>  'Đông Hải', 'parent_code' =>  4, 'path_with_type' => 'Huyện Đông Hải, Tỉnh Bạc Liêu', 'type' => 'huyen'],
        961 => ['id' => 961, 'name' =>  'Hoà Bình', 'parent_code' =>  4, 'path_with_type' => 'Huyện Hoà Bình, Tỉnh Bạc Liêu', 'type' => 'huyen'],
        964 => ['id' => 964, 'name' =>  'Cà Mau', 'parent_code' =>  15, 'path_with_type' => 'Thành phố Cà Mau, Tỉnh Cà Mau', 'type' => 'thanh-pho'],
        966 => ['id' => 966, 'name' =>  'U Minh', 'parent_code' =>  15, 'path_with_type' => 'Huyện U Minh, Tỉnh Cà Mau', 'type' => 'huyen'],
        967 => ['id' => 967, 'name' =>  'Thới Bình', 'parent_code' =>  15, 'path_with_type' => 'Huyện Thới Bình, Tỉnh Cà Mau', 'type' => 'huyen'],
        968 => ['id' => 968, 'name' =>  'Trần Văn Thời', 'parent_code' =>  15, 'path_with_type' => 'Huyện Trần Văn Thời, Tỉnh Cà Mau', 'type' => 'huyen'],
        969 => ['id' => 969, 'name' =>  'Cái Nước', 'parent_code' =>  15, 'path_with_type' => 'Huyện Cái Nước, Tỉnh Cà Mau', 'type' => 'huyen'],
        970 => ['id' => 970, 'name' =>  'Đầm Dơi', 'parent_code' =>  15, 'path_with_type' => 'Huyện Đầm Dơi, Tỉnh Cà Mau', 'type' => 'huyen'],
        971 => ['id' => 971, 'name' =>  'Năm Căn', 'parent_code' =>  15, 'path_with_type' => 'Huyện Năm Căn, Tỉnh Cà Mau', 'type' => 'huyen'],
        972 => ['id' => 972, 'name' =>  'Phú Tân', 'parent_code' =>  15, 'path_with_type' => 'Huyện Phú Tân, Tỉnh Cà Mau', 'type' => 'huyen'],
        973 => ['id' => 973, 'name' =>  'Ngọc Hiển', 'parent_code' =>  15, 'path_with_type' => 'Huyện Ngọc Hiển, Tỉnh Cà Mau', 'type' => 'huyen']
    ];


    protected static $locations = [
        1 =>'Hà Nội',
        2 =>'Hồ Chí Minh',
        3 =>'An Giang',
        4 =>'Bạc Liêu',
        5 =>'Bà Rịa - Vũng Tàu',
        6 =>'Bắc Cạn',
        7 =>'Bắc Giang',
        8 =>'Bắc Ninh',
        9 =>'Bến Tre',
        10=>'Bình Dương',
        11=>'Bình Định',
        12=>'Bình Phước',
        13=>'Bình Thuận',
        14=>'Cao Bằng',
        15=>'Cà Mau',
        16=>'Cần Thơ',
        17=>'Đà Nẵng',
        18=>'Đắc Lắc',
        19=>'Đắc Nông',
        20=>'Điện Biên',
        21=>'Đồng Nai',
        22=>'Đồng Tháp',
        23=>'Gia Lai',
        24=>'Hà Giang',
        25=>'Hà Nam',
        26=>'Hà Tây',
        27=>'Hà Tĩnh',
        28=>'Hải Dương',
        29=>'Hải Phòng',
        30=>'Hậu Giang',
        31=>'Hòa Bình',
        32=>'Hưng Yên',
        33=>'Khánh Hòa',
        34=>'Kiên Giang',
        35=>'Kon Tum',
        36=>'Lai Châu',
        37=>'Lạng Sơn',
        38=>'Lào Cai',
        39=>'Lâm Đồng',
        40=>'Long An',
        41=>'Nam Định',
        42=>'Nghệ An',
        43=>'Ninh Bình',
        44=>'Ninh Thuận',
        45=>'Phú Thọ',
        46=>'Phú Yên',
        47=>'Quảng Bình',
        48=>'Quảng Nam',
        49=>'Quảng Ngãi',
        50=>'Quảng Ninh',
        51=>'Quảng Trị',
        52=>'Sóc Trăng',
        53=>'Sơn La',
        54=>'Tây Ninh',
        55=>'Thái Bình',
        56=>'Thái Nguyên',
        57=>'Thanh Hóa',
        58=>'Thừa Thiên Huê',
        59=>'Tiền Giang',
        60=>'Trà Vinh',
        61=>'Tuyên Quang',
        62=>'Vĩnh Long',
        63=>'Vĩnh Phúc',
        64=>'Yên Bái',
        65=>'Khác'
    ];
    
    /**
     * Ngành nghề
     */
    protected static $nganh_nghe = [
        1 => 'Tiêu dùng',
        3 => 'Xây dựng',
        4 => 'Truyền thông',
        5 => 'Sản xuất',
        6 => 'Tài chính',
        7 => 'Y tế',
        8 => 'Dịch vụ',
        9 => 'Khách sạn & Du lịch',
        10 => 'Vận tải',
        11 => 'Công nghệ',
        12 => 'Sale',
        13 => 'Marketing',
    ];

    /**
     * Ngành nghề
     */
    protected static $categories = [
        1 => 'Tiêu dùng',
        3 => 'Xây dựng',
        4 => 'Truyền thông',
        5 => 'Sản xuất',
        6 => 'Tài chính',
        7 => 'Y tế',
        8 => 'Dịch vụ',
        9 => 'Khách sạn & Du lịch',
        10 => 'Vận tải',
        11 => 'Công nghệ',
        12 => 'Sale',
        13 => 'Marketing',
    ];

    /**
     * Chuyên môn
     */
    protected static $specialize = [
        1 => [   
            'id' => 1,
            'category_id' => 1,
            'name' => 'Siêu thị'
        ],
        2 => [   
            'id' => 2,
            'category_id' => 1,
            'name' => 'Thực phẩm & Đồ uống'
        ],
        3 => [   
            'id' => 3,
            'category_id' => 1,
            'name' => 'Thời Trang'
        ],
        4 => [   
            'id' => 4,
            'category_id' => 1,
            'name' => 'Mỹ phẩm'
        ],
        5 => [   
            'id' => 5,
            'category_id' => 1,
            'name' => 'Trang sức'
        ],
        6 => [   
            'id' => 6,
            'category_id' => 1,
            'name' => 'Ô tô / Xe máy'
        ],
        7 => [   
            'id' => 7,
            'category_id' => 1,
            'name' => 'Điện máy'
        ],
        8 => [   
            'id' => 8,
            'category_id' => 1,
            'name' => 'Thiết bị văn phòng'
        ],
        9 => [
            'id'   => 9,
            'category_id' => 3,
            'name' => 'Bđs'
            ],
        10 => [
            'id'   => 10,
            'category_id' => 3,
            'name' => 'Nội thất'
            ],
            
        11 => [
            'id'   => 11,
            'category_id' => 4,
            'name' => 'Báo Chí/Truyền hình'
            ],
        12 => [
            'id'   => 12,
            'category_id' => 4,
            'name' => 'Tiếp thị /Quảng cáo/online media'
            ],
            
        13 => [
            'id'   => 13,
            'category_id' => 5,
            'name' => 'Sơn/Hóa chất'
            ],
        14 => [
            'id'   => 14,
            'category_id' => 5,
            'name' => 'Dược phẩm'
            ],
        15 => [
            'id'   => 15,
            'category_id' => 5,
            'name' => 'Nông lâm nghiệp'
            ],
        16 => [
            'id'   => 16,
            'category_id' => 5,
            'name' => 'Khoáng sản'
            ],
        17 => [
            'id'   => 17,
            'category_id' => 5,
            'name' => 'Thủ công mỹ nghệ'
            ],

        18 => [
            'id' => 18,
            'category_id' => 6,
            'name' => 'Ngân hàng'
            ],
        19 => [
            'id' => 19,
            'category_id' => 6,
            'name' => 'Chứng Khoán'
            ],
        20 => [
            'id' => 20,
            'category_id' => 6,
            'name' => 'Bảo hiểm'
            ],
            
            
        21 => [
            'id' => 21,
            'category_id' => 7,
            'name' => 'Dịch vụ Y tế'
            ],
        22 => [
            'id' => 22,
            'category_id' => 7,
            'name' => 'Thiết bị Y Tế'
            ],
            
            
        23 => [
            'id' => 23,
            'category_id' => 8,
            'name' => 'SPA / Làm đẹp'
            ],
        24 => [
            'id' => 24,
            'category_id' => 8,
            'name' => 'Thể thao'
            ],
        25 => [
            'id' => 25,
            'category_id' => 8,
            'name' => 'Giải trí / Vui chơi'
            ],
        26 => [
            'id' => 26,
            'category_id' => 8,
            'name' => 'Phi chính phủ/Phi lợi nhuận'
            ],
        27 => [
            'id' => 27,
            'category_id' => 8,
            'name' => 'Giáo dục/Đào tạo'
            ],
        28 => [
            'id' => 28,
            'category_id' => 8,
            'name' => 'Biên, Phiên dịch'
            ],
        29 => [
            'id' => 29,
            'category_id' => 8,
            'name' => 'Tổ chức sự kiện'
            ],
        30 => [
            'id' => 30,
            'category_id' => 8,
            'name' => 'Luật/Pháp lý'
            ],
            
            
        31 => [
            'id' => 31,
            'category_id' => 9,
            'name' => 'Hàng Không'
            ],
        32 => [
            'id' => 32,
            'category_id' => 9,
            'name' => 'Nhà Hàng/ Khách Sạn'
            ],
        33 => [
            'id' => 33,
            'category_id' => 9,
            'name' => 'Du lịch'
            ],
            
            
        34 => [
            'id' => 34,
            'category_id' => 10,
            'name' => 'Kho vận'
            ],
        35 => [
            'id' => 35,
            'category_id' => 10,
            'name' => 'Xuất Nhập khẩu'
            ],
        36 => [
            'id' => 36,
            'category_id' => 10,
            'name' => 'logistics'
            ],
            
            
        37 => [
            'id' => 37,
            'category_id' => 11,
            'name' => 'Phần mềm'
            ],
        38 => [
            'id' => 38,
            'category_id' => 11,
            'name' => 'Phần cứng'
            ],
        38 => [
            'id' => 38,
            'category_id' => 11,
            'name' => 'Thiết kế đồ họa WEB'
            ],
        40 => [
            'id' => 40,
            'category_id' => 11,
            'name' => 'Game'
            ],
        41 => [
            'id' => 41,
            'category_id' => 11,
            'name' => 'Thương Mại Điện tử'
            ],
            
            
        42 => [
            'id' => 42,
            'category_id' => 12,
            'name' => 'Bán hàng online'
            ],
        43 => [
            'id' => 43,
            'category_id' => 12,
            'name' => 'Bán hàng tại cửa hàng'
            ],
        44 => [
            'id' => 44,
            'category_id' => 12,
            'name' => 'Bancassurance'
            ],
        45 => [
            'id' => 45,
            'category_id' => 12,
            'name' => 'Chăm sóc khách hàng'
            ],
        46 => [
            'id' => 46,
            'category_id' => 12,
            'name' => 'Kinh doanh'
            ],
        47 => [
            'id' => 47,
            'category_id' => 12,
            'name' => 'Phát triển thị trường'
            ],
        48 => [
            'id' => 48,
            'category_id' => 12,
            'name' => 'Quan hệ khách hàng'
            ],
        49 => [
            'id' => 49,
            'category_id' => 12,
            'name' => 'Sale Admin'
            ],
        50 => [
            'id' => 50,
            'category_id' => 12,
            'name' => 'Telesales'
            ],
        51 => [
            'id' => 51,
            'category_id' => 12,
            'name' => 'Tư vấn bán hàng'
            ],
        52 => [
            'id' => 52,
            'category_id' => 12,
            'name' => 'Tư vấn tài chính'
            ],
            
            
        53 => [
            'id' => 53,
            'category_id' => 13,
            'name' => 'Account '
            ],
        54 => [
            'id' => 54,
            'category_id' => 13,
            'name' => 'Art Director'
            ],
        55 => [
            'id' => 55,
            'category_id' => 13,
            'name' => 'Brand Management'
            ],
        56 => [
            'id' => 56,
            'category_id' => 13,
            'name' => 'Consumer Market Intelligence'
            ],
        57 => [
            'id' => 57,
            'category_id' => 13,
            'name' => 'Content Marketing'
            ],
        58 => [
            'id' => 58,
            'category_id' => 13,
            'name' => 'Copywriter'
            ],
        59 => [
            'id' => 59,
            'category_id' => 13,
            'name' => 'Designer'
            ],
        60 => [
            'id' => 60,
            'category_id' => 13,
            'name' => 'Digital Advertising '
            ],
        61 => [
            'id' => 61,
            'category_id' => 13,
            'name' => 'Digital Marketing'
            ],
        62 => [
            'id' => 62,
            'category_id' => 13,
            'name' => 'Email Marketing'
            ],
        63 => [
            'id' => 63,
            'category_id' => 13,
            'name' => 'Facebook Marketing'
            ],
        64 => [
            'id' => 64,
            'category_id' => 13,
            'name' => 'Google Ads'
            ],
        65 => [
            'id' => 65,
            'category_id' => 13,
            'name' => 'Influencer marketing'
            ],
        66 => [
            'id' => 66,
            'category_id' => 13,
            'name' => 'Marketing online'
            ],
        67 => [
            'id' => 67,
            'category_id' => 13,
            'name' => 'Marketing tổng hợp'
            ],
        68 => [
            'id' => 68,
            'category_id' => 13,
            'name' => 'Mobile App Marketing'
            ],
        69 => [
            'id' => 69,
            'category_id' => 13,
            'name' => 'Planner'
            ],
        70 => [
            'id' => 70,
            'category_id' => 13,
            'name' => 'PR - Marketing'
            ],
        71 => [
            'id' => 71,
            'category_id' => 13,
            'name' => 'Quản trị Website'
            ],
        72 => [
            'id' => 72,
            'category_id' => 13,
            'name' => 'SEO'
            ],
        73 => [
            'id' => 73,
            'category_id' => 13,
            'name' => 'Social Media'
            ],
        74 => [
            'id' => 74,
            'category_id' => 13,
            'name' => 'Tổ chức sự kiện'
            ],
        75 => [
            'id' => 75,
            'category_id' => 13,
            'name' => 'Trade Marketing'
            ],
        76 => [
            'id' => 76,
            'category_id' => 13,
            'name' => 'Truyền thông '
            ],
        77 => [
            'id' => 77,
            'category_id' => 13,
            'name' => 'Video Marketing'
            ]
    ];

    protected static $ranks = [
        1 => 'Nhân viên',
        2 => 'Chuyên viên',
        3 => 'Trưởng nhóm',
        4 => 'Trưởng phòng',
        5 => 'Trưởng bộ phận',
        6 => 'Giám đốc ',
        7 => 'Giám sát',
        8 => 'Quản lý dự án',
    ];
    /**
     * Hình thức làm việc
     */
    protected static $models = [
        1 => 'Toàn thời gian',
        2 => 'Bán thời gian',
        3 => 'Thực tập sinh',
        4 => 'Freelancer',
    ];

    protected static $salaries = [
        3  => 'Thương lượng',
        2  => 'Cạnh tranh',
        4  => '1-3 triệu',
        5  => '3-5 triệu',
        6  => '5-7 triệu',
        7  => '7-10 triệu',
        8  => '10-12 triệu',
        9  => '12-15 triệu',
        10 => '15-20 triệu',
        11 => '20-25 triệu',
        12 => '25-30 triệu',
        13 => '30 triệu trở lên',
        99 => 'Khác'
    ];

    protected static $c_salaries = [
        '1-3'    => '1-3 triệu',
        '3-5'    => '3-5 triệu',
        '5-7'    => '5-7 triệu',
        '7-10'   => '7-10 triệu',
        '10-12'  => '10-12 triệu',
        '12-15'  => '12-15 triệu',
        '15-20'  => '15-20 triệu',
        '20-25'  => '20-25 triệu',
        '25-30'  => '25-30 triệu',
        '30'     => '30 triệu trở lên',
        'custom' => 'Khác',
        '1'      => 'Thương lượng'
    ];

    protected static $educations = [
        1 => 'Trên đại học',
        2 => 'Đại học',
        3 => 'Cao đẳng',
        4 => 'Trung cấp',
        5 => 'Trung học',
        7 => 'Lao động phổ thông',
        6 => 'Khác'
    ];

    protected static $languages = [
        1 => 'Tiếng Việt',
        2 => 'Tiếng Anh',
        3 => 'Tiếng Pháp',
        4 => 'Tiếng Nhật',
        5 => 'Tiếng Trung',
        6 => 'Tiếng Hàn',
        20 => 'Bất kỳ'
    ];


    protected static $experiences = [
        1 => 'Chưa có kinh nghiệm',
        2 => 'Dưới 1 năm',
        3 => '1 năm',
        4 => '2 năm',
        5 => '3 năm',
        6 => '4 năm',
        7 => '5 năm trở lên',
    ];

    protected static $times = [
        1 => '1 ngày',
        7 => '1 tuần',
        30 => '1 tháng',
        90 => '3 tháng',
        180 => '6 tháng',
    ];

    protected static $sizes = [
        1	=>	'Dưới 10 người',
        2	=>	'10-25',
        3	=>	'25-50',
        4	=>	'50-100',
        5	=>	'100-200',
        6	=>	'200-500',
        7	=>	'500-1000',
        8	=>	'1000-5000',
        9	=>	'5000-10000',
        10	=>	'Hơn 10000 người'
    ];

    protected static $credits = [
        200000 => '200.000 VND',
        300000 => '300.000 VND',
        400000 => '400.000 VND',
        500000 => '500.000 VND',
    ];

    protected static $genders = [
        '1' => 'Nam',
        '2'  => 'Nữ'
    ];


    protected static $job_sex = [
        0 => 'Không yêu cầu',
        1 => 'Nam',
        2 => 'Nữ'
    ];

    protected static $skill_lang = [
        'en' => 'Tiếng Anh',
        'fr' => 'Tiếng Pháp',
        'rs' => 'Tiếng Nga',
        'kr' => 'Tiếng Hàn',
        'cn' => 'Tiếng Trung',
        'jp' => 'Tiếng Nhật',
        'custom' => 'Ngôn ngữ khác',
    ];

    protected static $marrital_status = [
        0 => 'Chưa rõ',
        1 => 'Chưa lập gia đình',
        2 => 'Đã kết hôn'
    ];


    protected static $job_services = [
        1 => 'Tuyển gấp',
        2 => 'Hấp dẫn',
        3 => 'Tương cao',
        4 => 'Tuyển dụng nhanh',
        5 => 'Tiêu điểm'
    ];


    protected static $job_orientations = [
        1 => 'Mong muốn tìm được chỗ làm ổn định lâu dài',
        2 => 'Mong muốn tìm được chỗ làm có cơ hội thăng tiến tốt',
        3 => 'Mong muốn tìm được chỗ làm có mức lương tốt',
        4 => 'Mong muốn tìm được nơi có cơ hội cống hiến bản thân tốt'
    ];


    protected static $certificate_types = [
        1 => "Yếu",
        2 => "Trung bình",
        3 => "Khá",
        4 => "Giỏi"
    ];


    protected static $job_status = [
        1 => "Chờ duyệt",
        2 => "Đã duyệt",
        3 => "Tạm thời từ chối",
        4 => "Đã chỉnh sửa cho duyệt",
        5 => "Loại"
    ];


    protected static $service_packages = [
        1 => [
            ['id' => 2, 'name' => 'Miễn phí']
        ],
        4 => [
            ['id' => 12, 'name' => 'Tin hấp dẫn 2 tuần'],
            ['id' => 13, 'name' => 'Tin  hấp dẫn 4 tuần'],
            ['id' => 14, 'name' => 'Tin  hấp dẫn 8 tuần'],
            ['id' => 15, 'name' => 'Tin  hấp dẫn 12 tuần']
        ],
        5 => [
            ['id' => 31, 'name' => 'Xác thực 3 tuần'],
            ['id' => 32, 'name' => 'Xác thực 4 tuần'],
            ['id' => 33, 'name' => 'Xác thực 8 tuần'],
            ['id' => 34, 'name' => 'Xác thực 12 tuần']
        ],
        6 => [
            ['id' => 51, 'name' => 'Preium 4 tuần'],
            ['id' => 52, 'name' => 'Premium 8 tuần'],
            ['id' => 53, 'name' => 'Premium 12 tháng'],
            ['id' => 54, 'name' => 'Premium 24 tháng'],
            ['id' => 55, 'name' => 'Premium 36 tháng']
        ],
        8 => [
            ['id' => 22, 'name' => 'Tin tiêu điểm 2 tuần'],
            ['id' => 23, 'name' => 'Tin tiêu điểm 4 tuần'],
            ['id' => 24, 'name' => 'Tin tiêu điểm 8 tuần'],
            ['id' => 25, 'name' => 'Tin tiêu điểm 12 tuần']
        ]
    ];



    protected static $goi_dich_vu = [
        1 => [
            ['name' => 'cơ bản' ,'cv' => 1, 'tags'=> 3, ],
        ]
    ];


    protected static $ext_languages = [
        [
            'name' => 'Tiếng Anh',
            'id' => 'en',
            'types' => [
                ['id' => 1, 'name' => 'TOEIC'],
                ['id' => 2, 'name' => 'IELTS'],
                ['id' => 3, 'name' => 'TOEFL'],
                ['id' => 4, 'name' => 'SAT'],
                ['id' => 5, 'name' => 'GMAT'],
                ['id' => 6, 'name' => 'GRE']
            ]
        ],
        [
            'name' => 'Tiếng Pháp',
            'id' => 'fr',
            'types' => [
                ['id' => 1, 'name' => 'DELF A1'],
                ['id' => 2, 'name' => 'DELF A2'],
                ['id' => 3, 'name' => 'DELF B1'],
                ['id' => 4, 'name' => 'DELF B2'],
                ['id' => 5, 'name' => 'DELF Prim'],
                ['id' => 6, 'name' => 'DELF Junior'],
                ['id' => 7, 'name' => 'TCF']
            ]
        ],
        [
            'name' => 'Tiếng Nga',
            'id' => 'rs',
            'types' => [
                ['id' => 1, 'name' => 'ТЭУ (TEU)'],
                ['id' => 2, 'name' => 'ТБУ (TBU)'],
                ['id' => 3, 'name' => 'ТРКИ-1 (TRKI-1)'],
                ['id' => 4, 'name' => 'ТРКИ-2 (TRKI-2)'],
                ['id' => 5, 'name' => 'ТРКИ-3 (TRKI-3)'],
                ['id' => 6, 'name' => 'ТРКИ-4 (TRKI-4)']
            ]
        ],
        [
            'name' => 'Tiếng Hàn',
            'id' => 'kr',
            'types' => [
                ['id' => 1, 'name' => 'TOPIK'],
                ['id' => 2, 'name' => 'KLPT']
            ]
        ],
        [
            'name' => 'Tiếng Trung',
            'id' => 'cn',
            'types' => [
                ['id' => 1, 'name' => 'HSK1'],
                ['id' => 2, 'name' => 'HSK2'],
                ['id' => 3, 'name' => 'HSK3'],
                ['id' => 4, 'name' => 'HSK4'],
                ['id' => 5, 'name' => 'HSK5'],
                ['id' => 6, 'name' => 'HSK6']
            ]
        ],
        [
            'name' => 'Tiếng Nhật',
            'id' => 'jp',
            'types' => [
                ['id' => 1, 'name' => 'N1'],
                ['id' => 2, 'name' => 'N2'],
                ['id' => 3, 'name' => 'N3'],
                ['id' => 4, 'name' => 'N4'],
                ['id' => 5, 'name' => 'N5']
            ]
        ]
    ];

    protected static $cv_statuses = [
        1 => 'Đã liên hệ',
        2 => 'Đã test',
        3 => 'Đã phỏng vấn',
        4 => 'Trúng tuyển',
        5 => 'Không trúng tuyển'
    ];

    protected static $regions = [
        'north' => '1,6,7,8,14,20,24,25,26,27,28,29,31,32,36,37,38,41,42,43,45,47,50,51,53,55,56,57,58,61,63,64',
        'south' => '2,3,4,5,9,10,11,12,13,15,16,17,18,19,21,22,23,30,33,34,35,39,40,44,46,48,49,52,54,59,60,62',
    ];
    
    /**
     * Thời gian trả hoa hồng
     */
    protected static $time_payment = [
        1 => 'Trong tháng',
        2 => '1 tháng sau',
        3 => '3 tháng sau',
        4 => '6 tháng sau'
    ];

    /**
     * Độ tuổi làm việc
     */
    protected static $ranger_age = [
        18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60
    ];

    /**
     * Phần trăm lương thử việc
     */
    protected static $percent_money = [
        1 => '80%',
        2 => '85%',
        3 => '90%',
        4 => '95%'
    ];

    /**
     * Hỗ trợ khi làm việc
     *
     * @var array
     */
    protected static $benefit_work = [
        1 => 'Trợ cấp ăn trưa',
        2 => 'Trợ cấp điện thoại',
        3 => 'Trợ cấp xăng xe',
        4 => 'Hỗ trợ máy tính',
    ];
    /**
     * Thời gian làm việc
     */
    protected static $time_model = [
        1 => 'Thứ 2 - Thứ 6',
        2 => 'Thứ 2 - Sáng thứ 7',
        3 => 'Thứ 2 - Hết thứ 7',
        4 => 'Theo ca',
        5 => 'Linh hoạt'
    ];

    /**
     * chuyên mục hỏi đáp
     */
    protected static $chuyen_muc = [
        1 => 'Chia sẻ',
        2 => 'Hỏi đáp',
        3 => 'Câu hỏi tình huống'
    ];

    /**
     * Loại hình công ty
     */
    protected static $model_company = [
        1 => 'Trong nước',
        2 => 'Tập đoàn đa quốc gia',
        3 => 'Start Up',
        4 => 'Vốn đầu tư nước ngoài (FDI)'
    ];
    
    /**
     * Ứng viên đánh giá / Là nhân viên
     */
    protected static $is_employee = [
        1 => 'Đã từng làm tại đây',
        2 => 'Đang làm tại đây',
    ];
    /**
     * Report reviews , blog
     */
    protected static $report_reviews_blog = [
        1 => 'Bài viết không đúng sự thật',
        2 => 'Bài viết vi phạm bản quyền tác giả',
        3 => 'Bài viết có nội dung tiêu cực',
        4 => 'Lý do khác'
    ];

    /**
     * @param $type
     * @param null $key
     * @param null $default
     * @return null
     */
    public static function get($type, $key = null, $default = null)
    {
        if (!property_exists(__CLASS__, $type)) {
            return $default;
        }

        $arr = self::$$type;

        if (is_null($key)) {
            return $arr;
        }


        // single value
        if (!is_null($key) && !is_array($key) && $key !== 'all') {
            if (!isset($arr[$key])) {
                return $default;
            }

            $result = ['id' => $key, 'name' => $arr[$key]];

            if ($type === 'locations') {
                $map = explode(',', self::$positions[$key]);

                $result['map'] = [
                    'lat' => $map[0],
                    'lon' => $map[1],
                ];
            }

            return $result;
        }
        // single value


        if (!is_null($key) && !is_array($key) && $key !== 'all') {
            if (!isset($arr[$key])) {
                return $default;
            }

            $result = ['id' => $key];

            if ($type === 'districts') {
                $result['districts'] = array_where(self::$districts, function ($k, $value) use ($key) {
                    if ($value['name'] == $key) {
                        return $k;
                    }
                });
            }
            return $result;
        }

        // multiple value
        $result = [];

        foreach ($arr as $id => $name) {
            $key = is_array($key) || $key === 'all' ? $key : [$key];

            if ($key === 'all' || in_array($id, $key)) {
                $item = [
                    'id' => $id,
                    'name' => $name,
                ];

                if ($type === 'locations') {
                    $map = explode(',', self::$positions[$id]);

                    $item['map'] = [
                        'lat' => $map[0],
                        'lon' => $map[1],
                    ];
                }

                $result[] = $item;
            }
        }

        return empty($result) ? $default : $result;
    }
}
