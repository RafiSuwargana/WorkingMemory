/**
 * Energy Test Image Preloader
 * Preloads all energy test images to prevent loading delays during test
 */

class EnergyPreloader {
    constructor() {
        this.images = [];
        this.loadedCount = 0;
        this.totalCount = 0;
        this.onProgressCallback = null;
        this.onCompleteCallback = null;
    }

    /**
     * Set progress callback function
     * @param {Function} callback - Called with (loadedCount, totalCount, percentage)
     */
    onProgress(callback) {
        this.onProgressCallback = callback;
        return this;
    }

    /**
     * Set completion callback function
     * @param {Function} callback - Called when all images are loaded
     */
    onComplete(callback) {
        this.onCompleteCallback = callback;
        return this;
    }

    /**
     * Generate list of all possible energy test images
     * Based on the image files available (B0.png, B1.png, etc.)
     */
    generateImageList() {
        const imageFiles = [
            'B0.png', 'B1.png', 'B10.png', 'B100.png', 'B11.png', 'B12.png', 
            'B2.png', 'B22.png', 'B3.png', 'B33.png', 'B4.png', 'B44.png', 
            'B444.png', 'B5.png', 'B55.png', 'B555.png', 'B6.png', 'B66.png', 
            'B666.png', 'B6666.png', 'B7.png', 'B77.png', 'B777.png', 'B8.png', 
            'B88.png', 'B888.png', 'B9.png', 'B99.png', 'Instruksi2.png', 'key9.png'
        ];
        
        return imageFiles.map(filename => `/images/energy/${filename}`);
    }

    /**
     * Preload a single image
     * @param {string} src - Image source path
     * @returns {Promise} - Resolves when image loads or fails
     */
    preloadImage(src) {
        return new Promise((resolve) => {
            const img = new Image();
            
            const handleLoad = () => {
                this.loadedCount++;
                this.images.push({
                    src: src,
                    element: img,
                    loaded: true
                });
                
                this.updateProgress();
                resolve(img);
            };

            const handleError = () => {
                console.warn(`Failed to load energy image: ${src}`);
                this.loadedCount++;
                this.images.push({
                    src: src,
                    element: null,
                    loaded: false
                });
                
                this.updateProgress();
                resolve(null);
            };

            img.onload = handleLoad;
            img.onerror = handleError;
            img.src = src;
        });
    }

    /**
     * Update progress and call callbacks
     */
    updateProgress() {
        const percentage = Math.round((this.loadedCount / this.totalCount) * 100);
        
        if (this.onProgressCallback) {
            this.onProgressCallback(this.loadedCount, this.totalCount, percentage);
        }

        if (this.loadedCount >= this.totalCount && this.onCompleteCallback) {
            this.onCompleteCallback();
        }
    }

    /**
     * Start preloading all energy test images
     * @returns {Promise} - Resolves when all images are processed
     */
    async preloadAll() {
        const imagePaths = this.generateImageList();
        this.totalCount = imagePaths.length;
        this.loadedCount = 0;
        this.images = [];

        console.log(`Starting to preload ${this.totalCount} energy images...`);

        // Preload images in parallel
        const promises = imagePaths.map(path => this.preloadImage(path));
        
        try {
            await Promise.all(promises);
            console.log('Energy image preloading complete!');
            return this.images;
        } catch (error) {
            console.error('Error during energy image preloading:', error);
            throw error;
        }
    }

    /**
     * Get preloaded image by filename
     * @param {string} filename - The filename to search for
     * @returns {HTMLImageElement|null} - The preloaded image element or null
     */
    getImage(filename) {
        const image = this.images.find(img => 
            img.src.endsWith(filename) && img.loaded
        );
        return image ? image.element : null;
    }

    /**
     * Check if a specific image is loaded
     * @param {string} filename - The filename to check
     * @returns {boolean} - True if image is loaded
     */
    isImageLoaded(filename) {
        const image = this.images.find(img => 
            img.src.endsWith(filename)
        );
        return image ? image.loaded : false;
    }

    /**
     * Get loading statistics
     * @returns {Object} - Object with loaded, total, and percentage
     */
    getStats() {
        return {
            loaded: this.loadedCount,
            total: this.totalCount,
            percentage: this.totalCount > 0 ? Math.round((this.loadedCount / this.totalCount) * 100) : 0
        };
    }
}

// Global preloader instance
window.energyPreloader = new EnergyPreloader();

// Auto-start preloading when script loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Energy preloader initialized');
});