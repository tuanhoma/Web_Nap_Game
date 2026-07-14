<?php

namespace App\Helpers;

/**
 * Validator
 * Validate input data với các rules cơ bản
 */
class Validator
{
    private array $errors = [];
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Validate required field
     */
    public function required(string $field, string $label = ''): self
    {
        $label = $label ?: $field;
        if (!isset($this->data[$field]) || trim($this->data[$field]) === '') {
            $this->errors[$field] = "{$label} không được để trống.";
        }
        return $this;
    }

    /**
     * Validate email
     */
    public function email(string $field, string $label = ''): self
    {
        $label = $label ?: $field;
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "{$label} không đúng định dạng email.";
        }
        return $this;
    }

    /**
     * Validate độ dài tối thiểu
     */
    public function minLength(string $field, int $min, string $label = ''): self
    {
        $label = $label ?: $field;
        if (isset($this->data[$field]) && mb_strlen($this->data[$field]) < $min) {
            $this->errors[$field] = "{$label} phải có ít nhất {$min} ký tự.";
        }
        return $this;
    }

    /**
     * Validate độ dài tối đa
     */
    public function maxLength(string $field, int $max, string $label = ''): self
    {
        $label = $label ?: $field;
        if (isset($this->data[$field]) && mb_strlen($this->data[$field]) > $max) {
            $this->errors[$field] = "{$label} không được quá {$max} ký tự.";
        }
        return $this;
    }

    /**
     * Validate khớp với field khác (confirm password)
     */
    public function matches(string $field, string $matchField, string $label = ''): self
    {
        $label = $label ?: $field;
        if (isset($this->data[$field]) && $this->data[$field] !== ($this->data[$matchField] ?? null)) {
            $this->errors[$field] = "{$label} không khớp.";
        }
        return $this;
    }

    /**
     * Validate alphanumeric (username)
     */
    public function alphaNumeric(string $field, string $label = ''): self
    {
        $label = $label ?: $field;
        if (isset($this->data[$field]) && !preg_match('/^[a-zA-Z0-9_]+$/', $this->data[$field])) {
            $this->errors[$field] = "{$label} chỉ được chứa chữ cái, số và dấu gạch dưới.";
        }
        return $this;
    }

    /**
     * Validate là số
     */
    public function numeric(string $field, string $label = ''): self
    {
        $label = $label ?: $field;
        if (isset($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->errors[$field] = "{$label} phải là số.";
        }
        return $this;
    }

    /**
     * Kiểm tra có lỗi không
     */
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Lấy danh sách lỗi
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Lấy lỗi đầu tiên
     */
    public function getFirstError(): ?string
    {
        return !empty($this->errors) ? reset($this->errors) : null;
    }

    /**
     * Lấy giá trị đã sanitize
     */
    public function getValue(string $field): ?string
    {
        return isset($this->data[$field]) ? trim($this->data[$field]) : null;
    }
}
