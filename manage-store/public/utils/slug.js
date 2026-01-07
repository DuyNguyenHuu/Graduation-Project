function generateSlug(str) {
    return str
        .toLowerCase()
        .normalize("NFD") // tách dấu tiếng Việt
        .replace(/[\u0300-\u036f]/g, "") // xóa dấu
        .replace(/[^a-z0-9\s-]/g, "") // bỏ ký tự đặc biệt
        .trim()
        .replace(/\s+/g, "-") // thay khoảng trắng bằng dấu gạch ngang
        .replace(/-+/g, "-"); // gộp nhiều dấu - liền nhau
}
