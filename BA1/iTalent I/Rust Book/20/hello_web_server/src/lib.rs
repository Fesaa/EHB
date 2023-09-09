use std::{error::Error, fmt};
use std::thread;
use std::sync::{mpsc, Arc, Mutex};

/// ThreadPool struct; implementation to handle closures
/// being passed down to threads for multi-threaded execution.
pub struct ThreadPool {
    workers: Vec<Worker>,
    sender: Option<mpsc::Sender<Job>>,
}

struct Worker {
    id: usize,
    thread: Option<thread::JoinHandle<()>>,
}

type Job = Box<dyn FnOnce() + Send + 'static>;

/// Error returned on invalid [`ThreadPool::build`]
#[derive(Debug)]
pub struct PoolCreationError;

impl fmt::Display for PoolCreationError {
    fn fmt(&self, f: &mut fmt::Formatter) -> fmt::Result {
        write!(f, "Could not create pool! Size must be greater than 0!")
    }
}
impl Error for PoolCreationError {}

impl Worker {
    fn new(id: usize, receiver: Arc<Mutex<mpsc::Receiver<Job>>>) -> Worker {
        let thread = thread::spawn(move || loop {
            let message = receiver
            .lock()
            .expect("Worker {id} failed to acquire the lock. An other thread left is Poisoned")
            .recv();

            match message {
                Ok(job) => {
                    println!("Worker {id} got a job; executing!");

                    job();
                },
                Err(_) => {
                    println!("Worker {id} disconnect. Shutting down thread.");
                    break;
                },
            }
        });
        Worker { id, thread: Option::Some(thread) }
    }
}


impl ThreadPool {

    /// Create a new ThreadPool.
    /// 
    /// The size is the number of threads in the pool.
    /// 
    /// [`ThreadPool::new`] is a panicking wrapper over [`ThreadPool::build`]
    /// it is recommended to use the latter and handle to error yourself.
    ///
    /// # Panics
    ///
    /// The [`ThreadPool::new`] function will panic if the size is zero.
    pub fn new(size: usize) -> ThreadPool {
        assert!(size > 0);
        ThreadPool::build(size).unwrap()
    }

    /// Safely create a new ThreadPool.
    /// 
    /// The size is the number of threads in the pool.
    pub fn build(size: usize) -> Result<ThreadPool, PoolCreationError> {
        if size == 0 {
            Err(PoolCreationError)
        } else {
            let (sender, receiver) = mpsc::channel::<Job>();
            let receiver = Arc::new(Mutex::new(receiver));

            let mut threads = Vec::with_capacity(size);

            for id in 0..size {
                threads.push(Worker::new(id, Arc::clone(&receiver)))
            }

            Ok(ThreadPool {workers: threads, sender: Option::Some(sender)})
        }
    }

    /// Execute a closure in a thread. Depending on the closures send through and
    /// the amount of threads it can take a while.
    pub fn execute<F>(&self, f: F)
    where 
        F: FnOnce() + Send + 'static
        {
            let job = Box::new(f);

            self.sender.as_ref().unwrap().send(job).unwrap();
        }
}

impl Drop for ThreadPool {
    fn drop(&mut self) {

        drop(self.sender.take());

        for worker in &mut self.workers {
            println!("Shutting down worker {}", worker.id);

            if let Option::Some(thread) = worker.thread.take() {
                thread.join().unwrap();
            }
        }
    }
}

#[cfg(test)]
mod tests {
    use super::*;


    #[test]
    #[should_panic]
    fn panics_when_invalid_size() {
        ThreadPool::new(0);
    }
}