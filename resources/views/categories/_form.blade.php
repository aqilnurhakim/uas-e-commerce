<div class="mb-3">
    <label class="form-label fw-semibold">Nama Kategori</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name ?? '') }}" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-4">
    <label class="form-label fw-semibold">Deskripsi</label>
    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Keterangan kategori (opsional)">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="d-flex gap-2">
    <button class="btn btn-primary">{{ $buttonText }}</button>
    <a href="{{ route('categories.index') }}" class="btn btn-light border">Batal</a>
</div>
