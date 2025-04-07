public function up()
{
    Schema::create('nutrition_recommendations', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama Menu
        $table->text('nutrition'); // Informasi nutrisi
        $table->text('ingredients'); // Bahan-bahan
        $table->text('instructions'); // Cara membuat
        $table->enum('category', ['pagi', 'siang', 'malam', 'snack']); // Kategori makanan
        $table->string('image')->nullable(); // Gambar
        $table->timestamps();
    });
}
