<?

// I was planning to do some OOP stuff like an abstract WebPipe + WebPipInterface class
// but KiSS is good for now.

function getInputs(){
  $data = file_get_contents('php://input');
  switch( $_SERVER['CONTENT_TYPE'] ){
    case "application/json":  $data = json_encode($data);
                              $data = ( !$data || !isset($data['inputs']) ) ? array() : $data;
                              break;
  }
  return $data;
}

function serveOptions(){
  $ext = "plain";
  switch( $_SERVER['CONTENT_TYPE'] ){
    case "application/json":  $ext = "json"; break;
  }
  return file_get_contents( "specification.{$ext}" );
}

function servePost(){
  switch( $_SERVER['CONTENT_TYPE'] ){
    case "application/json":  return servePostJson(); break;
    default:
    case "text/plain": return servePostPlain(); break;
  }
}

function servePostPlain(){
  return formatOutput( process( getInputs() ) );
}

function servePostJson(){
  $output = (object)array( "outputs" => array() );
  foreach( getInputs() as $input ) $output->outputs[] = process($input);
  return formatOutput( $output );
}

function formatOutput( $output ){
  switch( $_SERVER['CONTENT_TYPE'] ){
    case "application/json":  return json_encode($output); break;
    case "text/html":         return "<pre>".htmlentities( implode("\n",$output->outputs) )."</pre>"; break;
    default:
    case "text/plain":        return $output; break;
  }
}

?>
