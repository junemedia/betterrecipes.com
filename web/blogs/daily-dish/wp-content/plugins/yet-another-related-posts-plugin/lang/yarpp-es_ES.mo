��    _                        
   '  q   2  �   �     m  $   �     �     �  "   �  '        -     M     V     c     �     �     �  &   �  /   �     	  *   >	  $   i	  /   �	  H   �	     
     
  Z   4
     �
  .   �
  n   �
     :      K     l  |   q     �                 #         D     ]     k  9   �  R   �               +     4  *   B     m     �     �     �  w   �  3   4  9   h  �  �  y   0  p   �  `     �   |      v   /  �   �  �   �     G    P  %   S     y     �  �   �  }   �  �   	  5  �  (     D   =     �     �     �     �     �     �     �     �     �  !   �  "        A     _     }     �     �     �     �     �     �  
   �  �   �  �   k  "   O  7   r     �     �  -   �  ,     '   ;  	   c     m  /   {  -   �     �     �  *      B   0   *   s   ;   �   6   �   .   !  P   @!     �!  )   �!  [   �!     0"  :   ="  �   x"     �"  .   #     >#  �   E#     �#     
$     $    3$  1   H%  '   z%     �%  "   �%  N   �%  ]   /&     �&     �&     �&     �&  E   �&  #   ('  5   L'     �'     �'  v   �'  >   (  ?   Z(  �  �(  �   6*  �   �*  �   _+  �   �+  M  �,  �   �-  2  �.  �   �/  	   {0    �0  >   �1     �1  +   �1  �   !2  �   3  �   �3  :  �4  )   �5  E   �5  
   B6  
   M6     X6     r6     �6     �6     �6     �6     �6  &   �6  "   �6  +   7  )   ?7     i7     r7  (   �7  	   �7     �7   or  "Relatedness" options "The Pool" "The Pool" refers to the pool of posts and pages that are candidates for display as related to the current entry. %f is the YARPP match score between the current entry and this related entry. You are seeing this value because you are logged in to WordPress as an administrator. It is not shown to regular visitors. (Update options to reload.) Automatically display related posts? Before / after (Excerpt): Before / after (excerpt): Before / after each related entry: Before / after related entries display: Before / after related entries: Bodies:  Categories:  Cross-relate posts and pages? Default display if no results: Disallow by category: Disallow by tag: Display options <small>for RSS</small> Display options <small>for your website</small> Display related posts in feeds? Display related posts in the descriptions? Display using a custom template file Do you really want to reset your configuration? Donate to mitcho (Michael Yoshitaka Erlewine) for this plugin via PayPal Example post  Excerpt length (No. of words): Follow <a href="http://twitter.com/yarpp/">Yet Another Related Posts Plugin on Twitter</a> For example: Help promote Yet Another Related Posts Plugin? If, despite this check, you are sure that <code>%s</code> is using the MyISAM engine, press this magic button: Match threshold: Maximum number of related posts: NEW! No YARPP template files were found in your theme (<code>TEMPLATEPATH</code>)  so the templating feature has been turned off. No related posts. Options saved! Order results: Please move the YARPP template files into your theme to complete installation. Simply move the sample template files (currently in <code>wp-content/plugins/yet-another-related-posts-plugin/yarpp-templates/</code>) to the <code>TEMPLATEPATH</code> directory. Please try <A>manual SQL setup</a>. RSS display code example Related Posts Related Posts (YARPP) Related entries may be displayed once you save your entry Related posts brought to you by <a href='%s'>Yet Another Related Posts Plugin</a>. Related posts: Reset options Settings Show excerpt? Show only posts from the past NUMBER UNITS Show only previous posts? Show password protected posts? Tags:  Template file: The MyISAM check has been overridden. You may now use the "consider titles" and "consider bodies" relatedness criteria. The YARPP database had an error but has been fixed. The YARPP database has an error which could not be fixed. The higher the match threshold, the more restrictive, and you get less related posts overall. The default match threshold is 5. If you want to find an appropriate match threshhold, take a look at some post's related posts display and their scores. You can see what kinds of related posts are being picked up and with what kind of match scores, and determine an appropriate threshold for your site. There is a new beta (%s) of Yet Another Related Posts Plugin. You can <a href="%s">download it here</a> at your own risk. There is a new version (VERSION) of Yet Another Related Posts Plugin available! You can <A>download it here</a>. These are the related entries for this entry. Updating this post may change these related posts. This advanced option gives you full power to customize how your related posts are displayed. Templates (stored in your theme folder) are written in PHP. This option automatically displays related posts right after the content on single entry pages. If this option is off, you will need to manually insert <code>related_posts()</code> or variants (<code>related_pages()</code> and <code>related_entries()</code>) into your theme files. This option displays related posts at the end of each item in your RSS and Atom feeds. No template changes are needed. This option displays the related posts in the RSS description fields, not just the content. If your feeds are set up to only display excerpts, however, only the description field is used, so this option is required for any display at all. This option will add the code %s. Try turning it on, updating your options, and see the code in the code example to the right. These links and donations are greatly appreciated. Titles:  To restore these features, please update your <code>%s</code> table by executing the following SQL directive: <code>ALTER TABLE `%s` ENGINE = MyISAM;</code> . No data will be erased by altering the table's engine, although there are performance implications. Trust me. Let me use MyISAM features. Update options Website display code example When the "Cross-relate posts and pages" option is selected, the <code>related_posts()</code>, <code>related_pages()</code>, and <code>related_entries()</code> all will give the same output, returning both related pages and posts. Whether all of these related entries are actually displayed and how they are displayed depends on your YARPP display options. YARPP is different than the <a href="http://wasabi.pbwiki.com/Related%20Entries">previous plugins it is based on</a> as it limits the related posts list by (1) a maximum number and (2) a <em>match threshold</em>. YARPP's "consider titles" and "consider bodies" relatedness criteria require your <code>%s</code> table to use the <a href='http://dev.mysql.com/doc/refman/5.0/en/storage-engines.html'>MyISAM storage engine</a>, but the table seems to be using the <code>%s</code> engine. These two options have been disabled. Yet Another Related Posts Plugin Options by <a href="http://mitcho.com/">mitcho (Michael 芳貴 Erlewine)</a> category consider consider with extra weight date (new to old) date (old to new) day(s) do not consider month(s) more&gt; require at least one %s in common require more than one %s in common score (high relevance to low) score (low relevance to high) tag title (alphabetical) title (reverse alphabetical) week(s) word o Opciones "Relatedness" "The Pool" "The Pool" se refiere al fondo de Publicaciones y Páginas que son candidatos para visualizar como relacionados con la actual Entrada. %f es la combinación YARPP que califica entre la actual entrada y esta entrada relacionada. Estás viendo este valor porque estás dentro de la sesión en WordPress como administrador. No se muestra a los visitantes regulares. (Actualizar opciones para cargar.) Visualizar Automáticamente Publicaciones Relacionadas? Antes / Después (Pasaje): Antes / Después (pasaje): Antes / Después de cada Entrada Relacionada: Antes / Después visualización de entradas: Antes / Después Entradas Relacionadas: Cuerpos:  Categorías:  Publicaciones y Páginas Cruzadas-Relacionadas? Falta de Visualización si no hay resultados: Anular por categoría: Anular por etiqueta: Visualizar opciones <small>por RSS</small> Visualizar Opciones para tu sitio <small>para su sitio web</small> Visualizar Opciones Relacionadas en feeds? Visualizar Publicaciones Relacionadas en las Descripciones? Visualizar usando un archivo de plantilla para cliente De verdad quieres restaurar tu configuración? Hacer Donación a mitcho (Michael Yoshitaka Erlewine) por este plugin via PayPal Ejemplo de Publicación  Longitud de Pasaje (Número de Palabras): Segúir <a href="http://twitter.com/yarpp/">Yet Another Related Posts Plugin en Twitter</a> Por Ejemplo: Ayuda para promover aún Yet Another Related Posts Plugin? Si a pesar de esta revisión, estás seguro de que <code>%s</code> está utilizando el motor MyISAM, presiona este mágico botón: Umbral que combina: Número Máximo de Publicaciones Relacionadas: NUEVO! Ningunos archivos de plantillas YARPP fueron encontradas en su tema (<code>TEMPLATEPATH</code>) así que las carácterísticas de la plantillas se han deshabilitado. Publicaciones no relacionadas. Opciones guardadas! Orden de Resultados: Favor de mover el archivo de plantillas YARPP a tu tema para completar Instalación. Simplemente mover las mismas muestras de plantillas (actualmente en <code>wp-content/plugins/yet-another-related-posts-plugin/yarpp-templates/</code>) al directorio <code>TEMPLATEPATH</code>. Favor de inrentar <a>manual SQL instalación</a>. Visualización RSS (ejemplo de código) Publicaciones Relacionadas Publicaciones relacionadas (YARPP) Entradas relacionadas podrían ser visualizadas una vez que Guardes tu Entrada Publicaciones relacionadas que recibes por <a href='%s'>Yet Another Related Posts Plugin</a>. Publicaciones relacionadas: Opciones de Restauración Configuración Mostrar pasaje? Mostrar únicamente Publicaciones de las pasadas UNIDADES de NÚMEROS Mostrar solo Previas Publicaciones? Mostrar las Publicaciones protegidas por contraseña? Etiquetas:  Archivo de plantilla: La revisión MyISAM ha sido anulada. Ahora podrías usar "consider titles" y "consider bodies" criterios de relación. La base de datos YARPP tuvo un error pero ha sido solucionado. La base de datos YARPP tuvo un error que no se pudo solucionar. Mientras más alto el umbral de combinación, más restrictivo, y en total, obtienes menos Publicaciones Relacionadas. La falta que combina o concuerda como límite, es 5. Si quieres encontrar una combinación apropiada para el umbral en un número límite, da un vistazo a algunas Publicaciones Relacionadas que se pueden visualizar y sus calificaciones, y determina un tamaño límite apropiado para tu sitio. Hay una Nueva Versión Beta (%s) de Yet Another Related Posts Plugin. Puedes descargarlo aquí <a href="%s">descargarlo aquí</a> bajo tu propio riesgo. Hay una Nueva Versión (VERSIÓN) de Yet Another Related Posts Plugin. Puedes descargarlo aquí <a>descargarlo aquí</a> bajo tu propio riesgo. Estas son las entradas relacionadas para esta Entrada. Actualizar esta Publicación podría cambiar estas Publicaciones relacionadas. Esta opción avanzada, te da completo poder para adaptar cómo tus Publicaciones Relacionadas serán visualizadas. Las Plantillas (almacenadas en tu folder de temas) están escritos en PHP. Esta opción, automáticamente visualiza publicaciones relacionadas justo después del contenido en Entradas únicas de Página. Si esta opción está inhabilitada, necesitarás insertar manualmente <code>related_posts()</code> o las variantes (<code>related_pages()</code> y <code>related_entries()</code>) en tus archivos de temas. Esta opción visualiza Publicaciones Relacionadas al final de cada artículo en tu RSS y Atom Feeds. No son necesarios los cambios de plantillas. Esta opción permite visualizar las Publicaciones Relacionadas en los campos de RSS, no solamente el contenido. Si tus feeds están configurados para solamente visualizar pasajes, de cualquier modo, solo la descripción del campo se utiliza, así que esta opción se requiere para cualquier visualización. Esta opción sumará %s al código. Intenta encenderlo, actualizando tus opciones, y verás el código en el código de ejemplo a la derecha. Estos enlaces y donaciones son grandemente apreciados. Títulos: Para restaurar estas características, por favor actualiza la tabla <code>%s</code> ejecutando los siguientes SQL directive: <code>ALTER TABLE `%s` ENGINE = MyISAM;</code>. Ningún dato será eliminado por alterar by el motor de la tabla, aunque hay implicaciones de funciones. Confía en mi. Permíteme usar las caracyerísticas de MyISAM. Opciones de Actualización Sitio, ejemplo de visualización de código Cuando la opción "Cruz-se refieren blogs y páginas" es seleccionada, el código <code>related_posts()</code>, <code>related_pages()</code>, y <code>related_entries()</code> todos dan el mismo resultado, regresando las dos páginas afines y blogs. Que estas Entradas Relacionadas sean actualmente visualizadas y cómo sean visualizadas, depende de tus opcioens de visualización YARPP. YARPP es diferente a <a href="http://wasabi.pbwiki.com/Related%20Entries">previos plugins sobre los que se basa en</a> como si limitara la lista de Publicaciones Relacionadas por: (1) Un número máximo (2) un <em>umbral de combinación</em>. YARPP's "consider titles" y "consider bodies" criterios de relaciones, requieren tu <code>%s</code> tabla para usar <a href='http://dev.mysql.com/doc/refman/5.0/en/storage-engines.html'>MyISAM storage engine</a>, pero la tabla parece estar usando <code>%s</code> engine. Estas dos opciones han sido deshabilitadas. Yet Another Related Posts Plugin Opciones por <a href="http://mitcho.com/">mitcho (Michael 芳貴 Erlewine)</a> categoría considerar considerar con peso extra fecha (nuevo a antiguo) fecha (antiguo a nuevo) día(s) no considerar mes(es) más&gt; requiere al menos del uno %s en común requiere más del uno %s en común calificación (De Mayor a Menor Relevancia) calificación  (Menor a Mayor Relevancia) etiqueta título (orden alfabético) título (Orden alfabpetico a la inversa) semana(s) palabra 