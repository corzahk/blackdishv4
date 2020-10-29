<?php


$lang['rtl']      = false;
$lang['lang']     = 'en';
$lang['close']    = 'Cerrar';
$lang['loading']  = 'Cargando...';
$lang['send']  = 'Enviado';
$lang['unknown']  = 'Desconocido';

# + Time
$lang['timedate']['time_second'] = "segundo";
$lang['timedate']['time_minute'] = "minuto";
$lang['timedate']['time_hour'] = "hora";
$lang['timedate']['time_day'] = "dia";
$lang['timedate']['time_week'] = "semana";
$lang['timedate']['time_month'] = "mes";
$lang['timedate']['time_year'] = "año";
$lang['timedate']['time_decade'] = "decada";
$lang['timedate']['time_ago'] = "ago";

$lang['monday']    = "lunes";
$lang['tuesday']   = "martes";
$lang['wednesday'] = "miercoles";
$lang['thursday']  = "jueves";
$lang['friday']    = "viernes";
$lang['saturday']  = "sabado";
$lang['sunday']    = "domingo";

$lang['created_at'] = "Creado en";
$lang['updated_at'] = "Actualizado en";
$lang['accepted_at'] = "Aceptado en";


# + Sign in (login)
$lang['login'] = [
	"title"    => "Login:",
	"username" => "Tu Usuario or Email",
	"password" => "Tu Password",
	"keep"     => "Recordarme",
	"forget"   => "Se te Olvidó tu Contraseña
	!",
	"btn"      => "Login",
	"footer"   => "No Tienes una Cuenta?",
	"footer_l" => "Registrate",
	"social"   => "O Inicie Sesión Usando las Redes Sociales",
	"alert"    => [
  	"required"   => "Dejaste el nombre de usuario o la contraseña vacía!",
  	"moderat"    => "La membresía ha sido prohibida por el administrador, si cree que esto es un error, no dude en contactarnos.",
  	"activation" => "La membresía necesita activación por correo electrónico.",
  	"approve"    => "La membresía debe ser aprobada por la administración.",
    "success"    => "Has iniciado sesión correctamente, deseamos que lo pases bien.",
    "social"     => "Hay un problema con su ID social, el nombre de usuario con el que desea iniciar sesión no es suyo o ya existe con un ID social diferente.!",
    "error"      => "El nombre de usuario o la contraseña no están disponibles!"
  ]
];



# + Sign up
$lang['signup'] = [
	"title"     => "Registrate:",
	"username"  => "Tu Usuario",
	"password"  => "Tu Password",
	"rpassword" => "Re-Password",
	"email"     => "Tu Email",
	"email_p"   => "Le enviaremos un mensaje para confirmar su correo electrónico!",
	"btn"       => "Registrar",
	"social"    => "O regístrate usando las redes sociales",
	"footer"    => "Tiene usted una cuenta?",
	"footer_l"  => "Registrarse",
	"alert"     => [
    "required"         => "Todos los campos marcados con * son obligatorios",
    "char_username"    => "El nombre de usuario debe contener solo letras!",
    "limited_username" => "¡El nombre de usuario debe tener un límite de entre 3 y 15 caracteres!",
    "exist_username"   => "¡El nombre de usuario ya existe!",
    "limited_pass"     => "La contraseña debe tener un límite de entre 6 y 12 caracteres.",
    "repass"           => "¡La contraseña debe coincidir con la contraseña!",
    "check_email"      => "Introduzca un correo electrónico válido.!",
    "exist_email"      => "La dirección de correo electrónico ya existe!",
    "birth"            => "Su fecha de nacimiento debe estar entre 1-1-2005 y 1-1-1942!",
    "success"          => "El proceso de registro ha finalizado con éxito
.",
    "success1"         => "El proceso de registro ha finalizado con éxito
. But, todavía necesita la aprobación de la administración.",
    "success2"         => "El proceso de registro ha finalizado con éxito
. But, todavía necesito activar por correo electrónico.",
    "error"            => "El nombre de usuario o la contraseña no están disponibles!"
  ]
];


# + Page: Alerts
$lang['alerts'] = [
	"no-data"         => "Datos no encontrados",
	"permission"      => "No puede acceder a esta página porque debe actualizar su plan!",
	"wrong"           => "Algo salió mal!",
	'required'        => "Todos los campos marcados con * son obligatorios!",
	'logout'          => "Estas seguro que quieres cerrar sesión?",
	'payment'         => "Pago exitoso!",
	'payment_f'       => "No se pudo recuperar el pago de PayPal!",
	'alldone'         => "Éxito, todo hecho!",
	'cartquantity'    => "Debes elegir la cantidad!",
	'cartsuccess'     => "El itme fue añadido a tu cesta",
	'withdraw_amount' => "No tienes el suficiente saldo!",
	'noorders'        => "Lo sentimos, este restaurante no puede recibir más pedidos para este mes.!",
	"danger"          => "Oh chasquido!",
	"success"         => "Bien hecho!",
	"warning"         => "Advertencia!",
	"info"            => "Aviso!"
];

# + Header
$lang['header'] = [
	"home"            => "Inicio",
	"explore"         => "Categorias",
	"restaurants"     => "Restaurants",
	"about"           => "Sobre nosotros",
	"contact"         => "Contacto",
	"plans"           => "Planes",
	"login"           => "Login",
	"dashboard"       => "Dashboard",
	"my_orders"       => "Mis ordenes",
	"your_restaurant" => " Restaurante dashboard",
	"testimonial"     => "Reñas",
	"testimonial_h"   => "Tus reseñas:",
	"testimonial_i"   => "escribe tu reseña",
	"testimonial_b"   => "Enviar",
	"change_password" => "Cambia tu Password",
	"change_pass_i1"  => "Password Actual",
	"change_pass_i2"  => "Nuevo Password",
	"change_pass_bt"  => "Enviar",
	"edit_details"    => "Editar Detalles",
	"logout"          => "Salir",

	"title"           => "Tu Comida Favorita [br]en Realidad Aumentada [br]& A Serivicio",
	"subtitle"        => "Vive una nueva experiencia.",
	"btn"             => "Ordena Ahora",
	"working_hours"   => "Horas Laborales",
	"call"            => "Llamar en línea",

	"search"          => "Buscar...",

	"today"          => "Hoy 10:00 am - 7:00 pm",
	"phone"          => "(+52) 81-1965-5211",
];

# + Home
$lang['home'] = [
	"nearby"           => "Explore sus restaurantes cercanos",
	"nearby_desc"      => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, [br]sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
	"best"           => "Explore nuestro mejor menú",
	"best_desc"      => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, [br]sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
	"addtocart"      => "Añadir al carrito",
	"more"           => "Load more",
	"how"            => "Cómo funciona",
	"how_desc"       => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, [br]sed do eiusmod tempor incididunt.",
	"how1"           => "Elija comidas",
	"how1_desc"      => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.",
	"how2"           => "Vea su platillo en Realidad Aumentada",
	"how2_desc"      => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.",
	"how3"           => "Elige forma de pago",
	"how3_desc"      => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.",
	"customers"      => "Lo que dicen nuestros clientes",
	"customers_desc" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, [br]sed do eiusmod tempor incididunt.",
	"help"           => "Tiene alguna pregunta en mente?[br]Dejanos ayudarte.",
	"help_btn"       => "Enviar",
	"links"          => "Links:",
	"unavailable"    => "Indisponible",
];

# + Cuisines
$lang['cuisines'] = [
	"title" => "Categorias",
	"desc"  => "Explore todos los artículos que tenemos",
];

# + Restaurants
$lang['restaurant'] = [
	"title"             => "Restaurantes",
	"desc"              => "Explore todos los artículos que tenemos",
	"reviews"           => "Reseñas",
	"service"           => "Servicio:",
	"all"               => "Mostrar todo",
	"delivery"          => "Entrega",
	"pickup"            => "Recoger",
	"working"           => "Trabajando:",
	"open_now"          => "Abierto Ahora",
	"cuisine"           => "Categoria:",
	"location"          => "Ubicacion:",
	"country"           => "Seleccionar país...",
	"city"              => "Escriba una ciudad",
	"payment"           => "Método de pago:",
	"visa"              => "Visa",
	"paypal"            => "Paypal",
	"cod"               => "Contra reembolso",
	"apply"             => "Aplicar filtro",

	"open"              => "Abierto",
	"close"             => "Cerrado",
	"book_table"        => "Reservar una mesa",
	"album"             => "Album",
	"reviews"           => "Reseñas",
	"menu"              => "Menu",
	"author"            => "Autor",
	"out"               => "Agotado",
	"opening_hours"     => "Horario de apertura",
	"latitude"          => "Latitud",
	"longitude"         => "Longitud",

	"title1"            => "Mis Restaurantes",
	"desc1"             => "Explore todos los artículos que tenemos",
	"tools"             => "Herramientas de restaurante",
	"items"             => "Platillos",
	"booking"           => "Reserva",
	"withdraw"          => "Retirar",
	"details"           => "Editar restaurante",
	"restaurant"        => "Restaurante",
	"orders"            => "Ordenes",

	"item_name"         => "Nombre Platillo",
	"selling_price"     => "Precio de venta",
	"main_price"        => "Precio principal",
	"item_restaurant"   => "Platillo de Restaurante",
	"item_menu"         => "Platillo's menu",
	"item_cuisine"      => "Platillo's categoria",
	"ingredients"       => "Ingredientes",
	"description"       => "Descripcion",
	"delivery_price"    => "Precio de entrega",
	"delivery_time"     => "Tiempo de entrega",
	"sizes"             => "Tamaño",
	"sizes_name"        => "Nombre",
	"sizes_price"       => "Precio de venta",
	"sizes_reduce"      => "precio antes de reducir",
	"extra"             => "Agregar complementos adicionales",
	"btn"               => "Enviar",

	"menu_title"        => "Menú de alimentos",
	"new_menu"          => "Crear Menu",
	"menu_name"         => "Nombre de Menu",
	"menu_restaurant"   => "restaurante",
	"menu_restaurant_l" => "Selecciona restaurante...",

	"new_withdraw"        => "Retirar",
	"with_amount"        => "Cantidad",
	"with_email"         => "E-mail de Paypal",
	"with_balance"         => "Su balance es :",

	"review_create"     => "Crear una reseña:",
	"review_content"    => "Revisar contenido",
	"review_rate"       => "¿Cuánto estás satisfecho?",
	"review_title"      => "Título de Revisión",

	"dash_sales"        => "Ventas totales:",
	"dash_earnings"     => "Ganancias Totales:",
	"dash_balance"      => "Balance:",
	"dash_short"        => "Estadísticas breves:",
	"dash_monthsales"   => "Ventas de este mes:",
	"dash_monthearn"    => "Ganancias de este mes:",
	"dash_todaysales"   => "Ventas de hoy:",
	"dash_todayearn"    => "Ganancias de hoy:",
	"dash_os"           => "Estadísticas por SO:",
	"dash_devices"      => "Estadísticas por dispositivos:",

	"de_new"            => "Crea un nuevo restaurante",
	"de_edit"           => "Editar detalles del restaurante",
	"de_all"            => "Todos los restaurantes",
	"de_basic"          => "Información básica",
	"de_location"       => "Ubicación",
	"de_album"          => "Album",
	"de_social"         => "Social",
	"de_hours"          => "Horas Laborales",
	"de_name"           => "Nombre del restaurante",
	"de_phone"          => "Teléfono del restaurante",
	"de_email"          => "Correo electrónico del restaurante",
	"de_delivery"       => "Tiempo de entrega aproximado",
	"de_cuisine"        => "Cocina",
	"de_cuisine_l"      => "Cocina selecta...",
	"de_services"       => "Servicios",
	"de_services_l"     => "Seleccionar servicio...",
	"de_deliveryand"    => "Entrega & amp; Recoger",
	"de_pickuponly"     => "Solo para recoger",
	"de_maps"           => "Google Maps",
	"de_profile"        => "Como perfil",
	"de_cover"          => "Como tapa",
	"de_delete"         => "Eliminar",
	"de_edit"           => "Editar",
	"de_facebook"       => "Identificación del facebook",
	"de_twitter"        => "ID de Twitter",
	"de_instagram"      => "ID de Instagram",
	"de_youtube"        => "ID de Youtube",
	"de_acceptorders"   => "Nosotros estamos aceptando nuevos pedidos",

	"it_edit"           => "Editar detalles del platillo",
	"it_new"            => "Crear un platillo nuevo",
	"it_all"            => "Todos los platillos",
	"it_name"           => "Nombre del árticulo",
	"it_orders"         => "Pedidos",

	"by"                => "por",
	"sorry"             => "<strong>Lo sentimos..</strong> Este restaurante no acepta nuevos pedidos.. Vuelve pronto. Gracias.",

];

# + Shopping Cart
$lang['cart'] = [
	"title"         => "Carrito de compras",
	"desc"          => "Explore todos los artículos que tenemos",

	"order_summary" => "Resumen del pedido",
	"subtotal"      => "Subtotal",
	"total"         => "Total",
	"shipping_fees" => "Gastos de envío",
	"billing"       => "Envío & amp; Datos de facturación",
	"name"          => "Nombre",
	"email"         => "Email",
	"phone"         => "Telefono",
	"address"       => "Direccion",
	"city"          => "Ciudad",
	"state"         => "Estado",
	"zip"           => "C.P",
	"country"       => "País",
	"country_s"     => "Selecciona País...",
	"gender"        => "Género",
	"gender_s"      => "Selecciona Género...",
	"male"          => "Masculino",
	"female"        => "
	Femenino",
	"card"          => "
	tarjeta",
	"pay"           => "Pagar",
	"pay_with"      => "Pagar con",
];

# + My Orders
$lang['myorders'] = [
	"title"             => "Mis ordenes",
	"desc"              => "Explore todos los artículos que tenemos",

	"delivered"         => "Entregado",
	"intheway"          => "En envio",
	"make_it_delivered" => "Hazlo entregado",
	"awaiting"          => "Esperando",
	"add_your_review"   => "Agrega tu evaluación",
	"invoice"           => "Factura",
	"invoice_id"        => "Factura ID:",
	"invoice_date"      => "Factura Fecha:",
	"invoice_from"      => "Desde:",
	"invoice_qty"       => "Cant.",
	"invoice_cost"      => "Costo unitario",
	"invoice_shipping"  => "Envío de la unidad",
	"invoice_total"     => "Total",
	"invoice_tshipping" => "Envío",
	"invoice_subtotal"  => "Subtotal",
	"name"              => "Nombre Completo",
];


# + User Details
$lang['details'] = [
	"title"       => "Administrar detalles",
	"desc"        => "Explore todos los artículos que tenemos",
	"firstname_l" => "Primer Nombre:",
	"firstname"   => "Tu Segundo Nombre",
	"lastname"    => "Tu Primer Apellido",
	"lastname_l"  => "Tu Segundo Apellido:",
	"username_l"  => "Usuario",
	"username"    => "Edita Usuario",
	"password_l"  => "Password",
	"password"    => "Editar Password",
	"email_l"     => "Email",
	"email"       => "Editar Email",
	"gender"      => "Gendero:",
	"male"        => "Masculino",
	"female"      => "Femenino",
	"phone"       => "Telefono:",
	"country_l"   => "Pais:",
	"country"     => "Pais",
	"state_l"     => "Estado/Region:",
	"state"       => "Estadp/Region",
	"city_l"      => "Ciudad:",
	"city"        => "Ciudad",
	"address_l"   => "Direccion Completa:",
	"address"     => "Direccion Completa",
	"image_n"     => "Ninguna imagen elegida...",
	"image_c"     => "Elegir imagen",
	"plan"        => "Plan:",
	"button"      => "Enviar info",
	"alert"       => [
    "success" => "El proceso de edición de información ha finalizado correctamente."
  ]
];



# + Plans / Payment
$lang['plans'] = [
	"title" => "Precios simples para todos!",
	"desc"  => "Precios diseñados para restaurantes de todos los tamaños. Siempre sepa lo que pagará. Todos los planes vienen con garantía de devolución del 100% del dinero.",
	"month" => "/por mes",
	"btn"   => "Empezar",
	"alert" => [
    "success" => "¡Se han calculado sus pagos!"
  ]
];




# + Dashboard

$lang['dash'] = [
	"orders"    => "Pedidos",
	"reviews"   => "Reseñas",
	"users"     => "Usuarios",
	"pages"     => "Páginas",
	"settings"  => "Configuraciones",
	"payments"  => "Pagos",
	"withdraw"  => "Retirar",
	"items"     => "Artículos",
	"all_menus" => "Todos los menús",
	"menu"      => "Menus",
	"cuisines"  => "Categorias",
	"publish"   => "Publicar",
	"unpublish" => "Anular publicación",
	"delete"    => "Eliminar",
	"edit"      => "Editar",
	"accept"    => "Aceptar",
	"refuse"    => "Negar",
	"athome"    => "En casa",

	"ordersdays" => "Estadísticas de pedidos en los últimos 7 días",
	"ordersmonths" => "Estadísticas de pedidos por meses",



	"hello"     => "Hola,",
	"welcome"     => "Bienvenido de nuevo a su panel.",
	"stats_line_d"     => "Estadísticas de los últimos 7 días",
	"stats_line_m"     => "Estadísticas de este año",
	"stats_bar_d"     => "Estadísticas de los últimos 7 días",
	"stats_bar_m"     => "Estadísticas de este año",
	"surveys"     => "Encuestas",
	"responses"     => "Respuestas",
	"questions"     => "Preguntas",
	"new_u"     => "Nuevos usuarios (24h)",
	"new_p"     => "Últimos pagos (24h)",
	"new_s"     => "Últimas encuestas (24h)",

	"u_create"    => "Crear un usuario",
	"u_users"     => "Miembros",
	"u_status"    => "Estado",
	"u_username"  => "Usuario",
	"u_plan"      => "Plan",
	"u_credits"   => "Créditos",
	"u_last_p"    => "Ultimo pago",
	"u_registred" => "Registrado en",
	"u_updated"   => "Actualizado en",

	"p_title"     => "Pagos",
	"p_user"      => "Usuario",
	"p_status"    => "Estado",
	"p_amount"    => "Cantidad",
	"p_paymentid" => "ID de pago",
	"p_payerid"   => "Identificación del pagador",

	"p_disacticate"     => "Opción de planes deseable",

	"set_title"    => "Configuración general",
	"set_stitle"   => "Título del sitio:",
	"set_keys"     => "Palabras clave del sitio:",
	"set_desc"     => "descripción del lugar:",
	"set_url"      => "Sitio URL:",
	"set_logo"     => "Logotipo del sitio:",
	"set_favicon"  => "Site Favicon:",
	"set_noreply"  => "No responda correo electrónico:",
	"set_register" => "Registro del sitio",
	"set_btn"      => "Enviar configuración",

	"alert" => [
    "success" => "La configuración se ha enviado correctamente."
  ]
];




# + Email

$lang['email'] = [
	"hi" => "Hi {n},",

	"delivered"      => "Confirma que recibiste tu paquete",
	"delivered_msg"  => "¡Su pedido {o} se ha entregado correctamente! Confirme con nosotros que ha recibido su artículo o háganos saber si hay algún problema con su compra haciendo clic en el botón a continuación.",

	"successful"     => "Tu pago fue exitoso!",
	"successful_msg" => "¡El pago del pedido {o} ha sido confirmado! Le avisaremos cuando se envíe su pedido.",

	"shipped"        => "¡Espere ver su paquete pronto!",
	"shipped_msg"    => "¡El pedido {o} ha sido enviado! Puede hacer clic a continuación para rastrear su paquete, verificar el estado de la entrega o ver más detalles.",

	"paid"           => "Felicitaciones, su artículo se vendió y ya se pagó.",
	"paid_msg"       => "Es hora de empacar su artículo {o} y enviarlo.",
	"paid_t"         => "Venta confirmada:",

	"contact"        => "Si tiene alguna pregunta, {l}!",
	"let"            => "Haznos saber",
	"go"             => "¡Ve al pedido!",
	"footer"         => "Este correo electrónico se envió a {e}. Recibió este correo electrónico porque se registró para obtener una cuenta de {s}.",

];
