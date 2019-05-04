import java.io.File;
import java.io.FileInputStream;
import java.io.PrintWriter;
import org.apache.tika.language.LanguageIdentifier;
import org.apache.tika.mymetadata.Metadata;
import org.apache.tika.parser.ParseContext;
import org.apache.tika.parser.html.HtmlParser;
import org.apache.tika.sax.BodyContentHandler;
public class big{


public static void main(String args[]) throws Exception



{

PrintWriter writer = new PrintWriter ("C:/Users/Neekita/Desktop/big.txt");

String dirPath = "C:/Users/Neekita/Downloads/Reuters/reutersnews";

File dir = new File(dirPath);

int count = 1;


try {



for(File file: dir.listFiles()){

	count++;
BodyContentHandler handler = new BodyContentHandler(-1);
    Metadata mymetadata = new Metadata();
    ParseContext mycontext = new ParseContext();


    HtmlParser htmlparser = new HtmlParser();


FileInputStream inputstream = new FileInputStream(file);


htmlparser.parse(inputstream, handler, mymetadata,mycontext);



String content = handler.toString();



String mywords[] = content.split(" ");



for(String indword: mywords)



{



if(indword.matches("[a-zA-Z]+\\.?"))



{



writer.print(indword + " ");



}



}



}



} catch (Exception e) {



System.err.println("Caught IOException: " + e.getMessage());



e.printStackTrace();



}



writer.close();



}







}