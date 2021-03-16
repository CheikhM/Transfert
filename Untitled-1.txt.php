<?php

 Schema::create('transfert', function (Blueprint $table) {
    $table->id();
    $table->float('amount');
    $table->float('unit_price');
    $table->unsignedBigInteger('currency')->nullable();
    $table->float('price');
    /** For later extention of the app */
    $table->unsignedBigInteger('from')->nullable();
    $table->unsignedBigInteger('to')->nullable();
    $table->foreign('from')->references('id')->on('users');

    $table->timestamps();
});
