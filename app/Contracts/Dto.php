<?php
namespace App\Contracts;

Interface Dto {
    public function transform(): Dto;
    public function validate(): Dto;
    public function fromArray($arr = []): Dto;
    public function value(): array;

}
