#!/bin/bash

# Image Optimization Script
# Converts PNG/JPG to WebP format and optimizes existing images
# Requires: imagemagick (brew install imagemagick)

set -e

IMAGE_DIR="apps/dqvietnam/public"
BACKUP_DIR="apps/dqvietnam/public_backup"

echo "========================================="
echo "Image Optimization Script"
echo "========================================="
echo ""

# Check if imagemagick is installed
if ! command -v magick &> /dev/null && ! command -v convert &> /dev/null; then
    echo "❌ Error: ImageMagick not installed"
    echo "Install with: brew install imagemagick"
    exit 1
fi

# Use 'magick' if available, otherwise use 'convert'
if command -v magick &> /dev/null; then
    MAGICK_CMD="magick"
else
    MAGICK_CMD="convert"
fi

echo "✓ ImageMagick found: $MAGICK_CMD"
echo ""

# Create backup directory
if [ ! -d "$BACKUP_DIR" ]; then
    echo "Creating backup directory..."
    mkdir -p "$BACKUP_DIR"
fi

# Function to optimize and create WebP
optimize_image() {
    local file=$1
    local filename=$(basename "$file")
    local extension="${filename##*.}"
    local basename="${filename%.*}"
    local webp_file="${file%.*}.webp"
    
    # Skip if already a webp file
    if [ "$extension" = "webp" ]; then
        return
    fi
    
    # Skip if WebP already exists
    if [ -f "$webp_file" ]; then
        echo "  ⏭️  WebP exists: $filename"
        return
    fi
    
    echo "  🔄 Processing: $filename"
    
    # Get image dimensions
    dimensions=$($MAGICK_CMD identify -format "%w %h" "$file")
    width=$(echo $dimensions | cut -d' ' -f1)
    height=$(echo $dimensions | cut -d' ' -f2)
    
    # WebP max dimension is 16383px
    max_dimension=16383
    needs_resize=false
    
    if [ "$width" -gt "$max_dimension" ] || [ "$height" -gt "$max_dimension" ]; then
        echo "     ⚠️  Image too large ($width x $height), resizing..."
        needs_resize=true
    fi
    
    # Create WebP version
    if [ "$needs_resize" = true ]; then
        # Resize first, then convert
        if [ "$extension" = "png" ]; then
            $MAGICK_CMD "$file" -resize "${max_dimension}x${max_dimension}>" -quality 85 -define webp:lossless=false "$webp_file"
        else
            $MAGICK_CMD "$file" -resize "${max_dimension}x${max_dimension}>" -quality 80 "$webp_file"
        fi
    else
        # Normal conversion
        if [ "$extension" = "png" ]; then
            $MAGICK_CMD "$file" -quality 85 -define webp:lossless=false "$webp_file"
        else
            $MAGICK_CMD "$file" -quality 80 "$webp_file"
        fi
    fi
    
    # Get file sizes
    original_size=$(du -h "$file" | cut -f1)
    webp_size=$(du -h "$webp_file" | cut -f1)
    
    echo "     Original: $original_size → WebP: $webp_size"
}

# Process all images
echo "Processing images in: $IMAGE_DIR"
echo ""

# Count files
total_files=$(find "$IMAGE_DIR" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" \) | wc -l | tr -d ' ')
echo "Found $total_files images to process"
echo ""

# Process each image
current=0
find "$IMAGE_DIR" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" \) | while read file; do
    current=$((current + 1))
    echo "[$current/$total_files]"
    optimize_image "$file"
done

echo ""
echo "========================================="
echo "✅ Optimization Complete!"
echo "========================================="
echo ""
echo "Next steps:"
echo "1. Update image references to use WebP with fallback"
echo "2. Test images in browser"
echo "3. Compare file sizes and quality"
echo ""

# Show space saved
original_total=$(du -sh "$IMAGE_DIR" | cut -f1)
echo "Total size: $original_total"
echo ""
