fn main(){
    //println!("Hello World");
    //let x = 10;
    //println!("x is {x}");
    //let x: i16 = 15;
    //println!("x is {x}");
    //mutability
    //let mut y = 5;
    //println!("y is {y}");
    //y = 10;
    //println!("y is {y}");
    //scope
    /*{
        let z = 50;
        let s = z;
    }*/
    //let s = z;//Compiler Error
    
    //shadowing
    //let t = 10;
    //let t = t + 10;
    //println!("t is {t}");

    //let u = 3;
    //println!(" u is: {u}");
    //let u = 3.0;
    //println!(" u is: {u}");

    //let v = 30;
    /*{
    //    let v = 40;
    //    println!("inner v is: {v}");
    }*/
    //println!("outer v is: {v}");

    // Constants
    //const MAX_VALUE: u32 = 100;
    //println!("{MAX_VALUE}");
    //MAX_VALUE = 1;//compile error

    //primitive data types
    //let unsigned_num: u8 = 5;
    //let signed_num: i128 = -12122002;
    //let float_num: f32 = 5.5;
    //let arch_1: usize = 5;
    //let arch_2: isize = 5;
    //let char = 'a';
    //let b: bool = true;
    //println!("{}",b);

    //type aliasing
    //type Age = u8;
    //let peter_age: Age = 42;
    //println!("{}",Age);//can't use a type alias as a constructor

    //type conversion
    //let a:i64 = 10;
    //let b:f64 = a as f64+0.5;
    //println!("{} {} {} {} {} {} {} {} {} {}", unsigned_num, signed_num, float_num, arch_1, arch_2, b, char, peter_age, a, b);

    //Compound Datatypes - &str and String
    //let fixed_str = "Fixed length string";
    //let mut flexible_str = String::from("This string grow");
    //flexible_str.push('s');

    // Arrays
    //let array_1 = [4, 5, 6, 8, 9];//let mut array_1: [i32, 5] = [4, 5, 6, 8, 9];
    //let num = array_1[3];
    //println!("{}", num);
    //println!("{:?}", array_1);
    //let array_2 = [0; 10];
    //println!("{:?}", array_2);
    //size of the array once declared cannot be changed and is of fixed type
    //indexing starts from 0

    // Vectors
    //let vec_1: Vec<i32> = vec![4, 5, 6, 8, 9];
    //no size information in vectors
    //can shrink and grow in size
    //elements of a vector need to be of the same type
    //let num = vec_1[3];
    //println!("{:?}", vec_1);
    //println!("{}", num);

    // Tuples
    //let my_info: (&str, i32, &str, i32) = ("Salary", 40000, "Age", 40);
    //println!("{:?}", my_info);
    //let salary_value = my_info.1;
    //println!("{:?}", salary_value);
    //let (salary, salary_value, age, age_value) = my_info;
    //println!("{:?}", array_1);

    //let unit: () = ();
    //functions that lack a specific value return this value
    //it is not a compound datatype but comes under tuples

    //function
    //function name convention is snakecase
    //return statement should not have a semicolon
    /*
    let return_m = my_fn(12,12);
    println!("{}",return_m);
    let arith = basic_math(12,12);
    println!("{:?}",arith);
     */

    //codeblocks
    /*let full_name : String = {
        let firstname: &str = "Kaivalya";
        let lastname: &str = "Vanguri";
        format!("{firstname} {lastname}")
    };
    print!("{full_name}");
    */

    //if else conditional
    /*let num = 40;
    if num < 50 {
        println!("The number is less than 50");
    } else {
        println!("The number is greater than or equal to 50");
    }

    let marks = 95;
    //let mut grade = 'N';

    let grade = if marks >= 90 {
        'A'
    } else if marks >= 80 {
        'B'
    } else if marks >= 70 {
        'C'
    } else {
        'F'
    };
    //returning values must be of the same data type

    let marks = 95;
    //let mut grade = 'N';

    //match conditional
    let grade = match marks {
        90..=100 => 'A',
        80..=89 => 'B',
        70..=79 => 'C',
        50..=69 => 'D',
        _ => 'F'
    };

    let marks = 70;
    let mut grade = 'N';

    match marks{
        90..=100 => grade = 'A',
        70..=89 => grade = 'B',
        50..=69 => grade = 'C',
        35..=49 => grade = 'D',
        _ => grade = 'F'
    }
    //match pattern statements must be of same datatype and must be exhaustive in nature
    //they must havve a default value 
    //
    //_ => 'F',
    //50..=69 => 'D',- unreachable pattern should be avoided
    */
    //Control Flow
    //infinite loop
    /*
    loop{
        println!("Simple loop");
    }
     */
    /*
    //loop with explicit break
    //labels always start with ' and are followed by :
    'outer: loop {
        println!("Simple loop");
        break 'outer;
    }
    //expression with a returning loop 
    let a = loop {
        println!("a");
        break 12;
    };
    format!("{}",a);
    println!("{}",a);
    let b = loop {
        break 1;
    };
    println!("{}",b);

    let vec = vec![45, 30, 85, 90, 41, 39];
    //for loop for a collective
    for i in vec {
        println!("{i}");
    }

    //while loop
    let mut num = 0;
    while num < 10 {
        num = num + 1;
    }*/

    
    /*PROBLEM 1
    let mut n = String::new();
    std::io::stdin()
        .read_line(&mut n)
        .expect("failed to read input.");
    let n: i32 = n.trim().parse().expect("invalid input");
    
    let mut square_of_sum = 0;
    let mut sum_of_squares = 0;
    let mut i = 1;
    while i<(n+1){
        square_of_sum = square_of_sum+i;
        sum_of_squares = sum_of_squares+i*i;
        i = i+1;
        //println!("{},{},{}",i,sum_of_squares,square_of_sum);
    }
    square_of_sum = square_of_sum*square_of_sum;
    let diff= if square_of_sum > sum_of_squares{square_of_sum - sum_of_squares} else {sum_of_squares-square_of_sum};
    println!("difference between {} and {} is {}",square_of_sum,sum_of_squares,diff);*/
    /*PROBLEM 2
let mut n = String::new();
    std::io::stdin()
        .read_line(&mut n)//can be an ok or error
        .expect("failed to read input.");
    let n: i32 = n.trim().parse().expect("invalid input"); 
    //let n = 10;
    let mut i = 1;
    let mut sum = 0;
    while i<(n+1){
        if i%3 == 0 || i%5 == 0{
            sum = sum + i;
        }
        i+=1;
    }   
    println!("{} {}",n,sum); */
    /*
    PROBLEM 3
    println!("{}", total_production(6, 5) as i32); // to round the values we use i32. just ignore for mow
    println!("{}", cars_produced_per_minutes(6, 5) as i32); // to round the values we use i32. just ignore for mow

    fn total_production(hours: u8, speed: u8) -> f32 {
        let success_rate: f32;
        let cars_produced: f32 = f32::from(hours)*221.0;
        success_rate = match speed{
            1..=4 => 1.0*cars_produced*f32::from(speed),
            5..=8 => 0.9*cars_produced*f32::from(speed),
            9..=10 => 0.77*cars_produced*f32::from(speed),
            _ => 0.0
        };
        success_rate
    }

    fn cars_produced_per_minutes(hours: u8, speed: u8) -> f32 {
        let success_rate: f32;
        if speed <= 4 {
            success_rate = 1.0;
        } else if speed >= 5 && speed <= 8 {
            success_rate = 0.9;
        } else {
            success_rate = 0.77;
        }

        ((hours as f32 * 221.0) * success_rate) / 60.0
     */
    /* Escape sequences
    \n : Newline character.
    \t : Tab space.
    \r : Carriage Return.
    \" : Double quote.
    \\ : Backward slash.
    *//*BONUS 
    println!(
        "I am doing {2} from {1} years and i {0} it",
        "like", 20, "programming"
    );

    println!(
        "{language} is a system programming language which is cool to {activity} in.",
        activity = "code",
        language = "Rust"
    );

    //reading user input data
    let mut n = String::new();
    std::io::stdin()
        .read_line(&mut n)
        .expect("failed to read input.");

    let n: f64 = n.trim().parse().expect("invalid input");
    println!("{n}");

    let _number_one = 45.0;
    let x = 40_000;

    static WELCOME: &str = "Welcome to Rust";
    //to refer large amount of data or interior utility
    const PI: f32 = 3.14;

    let a = PI;
    let b = PI;

    let c = WELCOME;
    let d = WELCOME;
    */
}
/*
rustc --version ------> version of rust
cargo --version ------> version of cargo of rust
rustup update ------> update rust 
rustc tutorial.rs ------> compile the code
./tutorial ------> show whats in the exe file
cargo new learning_rust ------> make a dir
cargo run ------> compile and execute
cargo build ------> build not run
cargo build --release ------> if build is for production

/*functions
fn my_fn(num1: i32, num2: i32) -> i64{
    println!("This is my function");
    println!("Computing Multiplication");
    i64::from(num1 * num2)
}
fn basic_math(num1: i32, num2: i32) -> (i32, i32, i64){
    println!("Computing Subtraction...");
    println!("Computing Addition...");
    println!("Computing Multiplication...");
    (num1 - num2, num1 + num2, i64::from(num1 * num2))
}
*/
/*
PROBLEM 4
fn palindrome(input: String) -> bool {
    let mut is_palindrome = true;
    if input.len() == 0 {
        is_palindrome = true;
    } else {
        let mut last = input.len() - 1;
        let mut first = 0;

        let my_vec = input.as_bytes();

        while first < last {
            if my_vec[first] != my_vec[last] {
                is_palindrome = false;
                break;
            }

            first += 1;
            last -= 1;
        }
    }
    is_palindrome
}
 */
/*
PROBLEM 5
fn main() {
    let mut flag = true;
    for a in 1..=1000 {
        for b in a + 1..1000 {
            // this ensures that a < b
            for c in b + 1..1000 {
                //  this ensure that b < c
                if a * a + b * b == c * c && a + b + c == 1000 {
                    println!(
                        "\n\n The required pathagorian triplet are ({}, {}, {}) \n\n",
                        a, b, c
                    );
                    flag = false;
                    break;
                }
            }
            if flag == false {
                break;
            }
        }
        if flag == false {
            break;
        }
    }
}

fn main() {
    for a in 1..=1000 {
        for b in a + 1..1000 {
            for c in b + 1..1000 {
                if a * a + b * b == c * c && a + b + c == 1000 {
                    println!(
                        "\n\n The required pathagorian triplet are ({}, {}, {}) \n\n",
                        a, b, c
                    );

                    return;
                }
            }
        }
    }
}

fn main() {
    for a in 1..=1000 {
        for b in a..=1000 - a {
            let c = 1000 - a - b;
            if a * a + b * b == c * c {
                println!("Got a triplet {:?}", (a, b, c));
            }
        }
    }
}
 */
/*PROBLEM 6
fn can_see_movie(age: i32, permission: bool) -> bool {
    (age >= 17) ||
    (age >= 13 && permission)
}
 */
 */
