<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;
use Stevebauman\Purify\Casts\PurifyHtmlOnSet;

class PurifyTest extends TestCase
{
    public $input = '<p>Perkembangan teknologi telah mengubah fundamental cara kita menjalani kehidupan sehari-hari. Dari penggunaan perangkat pintar hingga konektivitas Internet yang tak terputus, <strong>inovasi teknologi</strong> telah mempengaruhi hampir setiap aspek kehidupan kita. Misalnya, di sektor pendidikan, platform pembelajaran online telah memungkinkan akses yang lebih luas terhadap sumber daya pendidikan global, merubah cara kita belajar dan mengajar.</p><p>Di sektor kesehatan, teknologi telah membawa perubahan besar dengan adopsi perangkat medis canggih dan aplikasi kesehatan yang memudahkan pemantauan kesehatan individu. Namun, ada kekhawatiran tentang dampak negatif penggunaan teknologi terhadap kesehatan mental, terutama dalam konteks penggunaan media sosial yang berlebihan dan kekhawatiran tentang privasi data pribadi.</p><p>Selain itu, dalam sektor transportasi, teknologi telah menghadirkan revolusi dengan adopsi kendaraan listrik dan pengembangan kendaraan otonom. Namun, tantangan seperti infrastruktur yang belum siap dan isu keberlanjutan lingkungan masih menjadi fokus utama dalam mewujudkan mobilitas masa depan yang lebih efisien dan berkelanjutan.</p><figure class="image"><img style="aspect-ratio:3662/2451;" src="http://127.0.0.1:8000/storage/information_images/joel-mott-oiBYHxCZYIk-unsplash_1713752419.jpg" width="3662" height="2451"></figure>';

    public function test_clear_figure(): void
    {
        $this->app['config']->set('purify.configs.default', [
            'HTML.Allowed' => 'p',
        ]);

        $model = new PurifyingDefaultOnSetModel();
        $model->body = $this->input;

        $expected = '<p>Perkembangan teknologi telah mengubah fundamental cara kita menjalani kehidupan sehari-hari. Dari penggunaan perangkat pintar hingga konektivitas Internet yang tak terputus, inovasi teknologi telah mempengaruhi hampir setiap aspek kehidupan kita. Misalnya, di sektor pendidikan, platform pembelajaran online telah memungkinkan akses yang lebih luas terhadap sumber daya pendidikan global, merubah cara kita belajar dan mengajar.</p><p>Di sektor kesehatan, teknologi telah membawa perubahan besar dengan adopsi perangkat medis canggih dan aplikasi kesehatan yang memudahkan pemantauan kesehatan individu. Namun, ada kekhawatiran tentang dampak negatif penggunaan teknologi terhadap kesehatan mental, terutama dalam konteks penggunaan media sosial yang berlebihan dan kekhawatiran tentang privasi data pribadi.</p><p>Selain itu, dalam sektor transportasi, teknologi telah menghadirkan revolusi dengan adopsi kendaraan listrik dan pengembangan kendaraan otonom. Namun, tantangan seperti infrastruktur yang belum siap dan isu keberlanjutan lingkungan masih menjadi fokus utama dalam mewujudkan mobilitas masa depan yang lebih efisien dan berkelanjutan.</p>';

        $this->assertEquals($expected, $model->body);
    }


    public function test_clear_html_tag(): void
    {
        $this->app['config']->set('purify.configs.default', [
            'HTML.Allowed' => 'p',
        ]);

        $model = new PurifyingDefaultOnSetModel();
        $model->body = $this->input;

        $cleaned = strip_tags($model->body);

        $expected = 'Perkembangan teknologi telah mengubah fundamental cara kita menjalani kehidupan sehari-hari. Dari penggunaan perangkat pintar hingga konektivitas Internet yang tak terputus, inovasi teknologi telah mempengaruhi hampir setiap aspek kehidupan kita. Misalnya, di sektor pendidikan, platform pembelajaran online telah memungkinkan akses yang lebih luas terhadap sumber daya pendidikan global, merubah cara kita belajar dan mengajar.Di sektor kesehatan, teknologi telah membawa perubahan besar dengan adopsi perangkat medis canggih dan aplikasi kesehatan yang memudahkan pemantauan kesehatan individu. Namun, ada kekhawatiran tentang dampak negatif penggunaan teknologi terhadap kesehatan mental, terutama dalam konteks penggunaan media sosial yang berlebihan dan kekhawatiran tentang privasi data pribadi.Selain itu, dalam sektor transportasi, teknologi telah menghadirkan revolusi dengan adopsi kendaraan listrik dan pengembangan kendaraan otonom. Namun, tantangan seperti infrastruktur yang belum siap dan isu keberlanjutan lingkungan masih menjadi fokus utama dalam mewujudkan mobilitas masa depan yang lebih efisien dan berkelanjutan.';

        $this->assertEquals($expected, $cleaned);
    }

    public function test_replace_strong_tag_with_p_tag(): void
    {
        $this->app['config']->set('purify.configs.default', [
            'HTML.Allowed' => 'p,strong',
        ]);

        $model = new PurifyingDefaultOnSetModel();
        $model->body = $this->input;

        $dataMustCleaned = $model->body;

        $expected = '<p>Perkembangan teknologi telah mengubah fundamental cara kita menjalani kehidupan sehari-hari. Dari penggunaan perangkat pintar hingga konektivitas Internet yang tak terputus, <p>inovasi teknologi</p> telah mempengaruhi hampir setiap aspek kehidupan kita. Misalnya, di sektor pendidikan, platform pembelajaran online telah memungkinkan akses yang lebih luas terhadap sumber daya pendidikan global, merubah cara kita belajar dan mengajar.</p><p>Di sektor kesehatan, teknologi telah membawa perubahan besar dengan adopsi perangkat medis canggih dan aplikasi kesehatan yang memudahkan pemantauan kesehatan individu. Namun, ada kekhawatiran tentang dampak negatif penggunaan teknologi terhadap kesehatan mental, terutama dalam konteks penggunaan media sosial yang berlebihan dan kekhawatiran tentang privasi data pribadi.</p><p>Selain itu, dalam sektor transportasi, teknologi telah menghadirkan revolusi dengan adopsi kendaraan listrik dan pengembangan kendaraan otonom. Namun, tantangan seperti infrastruktur yang belum siap dan isu keberlanjutan lingkungan masih menjadi fokus utama dalam mewujudkan mobilitas masa depan yang lebih efisien dan berkelanjutan.</p>';

        $dataMustCleaned = str_replace('<strong>', '<p>', $dataMustCleaned);
        $dataMustCleaned = str_replace('</strong>', '</p>', $dataMustCleaned);

        $this->assertEquals($expected, $dataMustCleaned);
    }

}

class PurifyingDefaultOnSetModel extends Model
{
    protected $casts = [
        'body' => PurifyHtmlOnSet::class,
    ];
}
