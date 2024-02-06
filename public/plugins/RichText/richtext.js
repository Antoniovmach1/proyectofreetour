$(document).ready(function () {
    // Inicializar el Datepicker con rango
   

    // Inicializar el RichText
    $('.descripcionitem').richText({
            // Text formatting options
            bold: true,
            italic: true,
            underline: true,
        
            // Text alignment options
            leftAlign: true,
            centerAlign: true,
            rightAlign: true,
            justify: true,
        
            // List options
            ol: true,
            ul: true,
        
            // Title/Heading option
            heading: true,
        
            // Fonts options
            fonts: true,
            fontList: ["Arial", "Times New Roman", "Verdana"],
            fontColor: false,
            backgroundColor: false,
            fontSize: true,
        
            // Uploads options
            imageUpload: false,
            fileUpload: false,
        
            // Media options
            videoEmbed: false,
        
            // Link options
            urls: false,
        
            // Table options
            table: false,
        
            // Code options
            removeStyles: false,
            code: true,
        
            // Color options
            colors: ["#FF5733", "#00FF00", "#0000FF"],
        
            // Dropdowns options
            fileHTML: '',
            imageHTML: '',
        
            // Translations for UI elements
            translations: {
                'title': 'Custom Title',
                'bold': 'Custom Bold',
                'italic': 'Custom Italic',
                // ... (other translation settings)
            },
        
            // Privacy options
            youtubeCookies: false,
        
            // Preview options
            preview: false,
        
            // Placeholder text
            placeholder: 'Escribe aqui la descripcion del item...',
        
            // Developer settings
            useSingleQuotes: false,
            height: 300,
            adaptiveHeight: true,
            // ... (other developer settings)
        });
});